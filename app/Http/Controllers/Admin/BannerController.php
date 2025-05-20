<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Car;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    protected $fileUploadService;

    /**
     * Create a new controller instance.
     *
     * @param FileUploadService $fileUploadService
     * @return void
     */
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->middleware('auth');
        // $this->middleware('admin');
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of the banners.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Banner::with('car');

        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('main_content', 'LIKE', '%' . $searchTerm . '%');
            });

            Log::info('Banner search applied', [
                'search_term' => $searchTerm,
                'results_count' => $query->count()
            ]);
        }

        $banners = $query->orderBy('position', 'asc')
                         ->orderBy('id', 'asc')
                         ->paginate(10)
                         ->withQueryString();

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new banner.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cars = Car::where('isActive', true)->get();
        return view('admin.banners.create', compact('cars'));
    }

    /**
     * Store a newly created banner in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('Banner store method called', ['request_data' => $request->all()]);

        try {
            $request->validate([
                'main_content' => 'nullable|string|max:255',
                'title' => 'nullable|string|max:100',
                'position' => 'nullable|integer|min:0',
                'car_id' => 'nullable|exists:cars,id',
                'click_url' => 'nullable|string|max:255',
                'video_type' => 'required|in:upload,existing',
                'video' => 'nullable|file|mimes:mp4,mov,avi|max:1048576', // 1GB (1024 * 1024 KB)
                'existing_video' => 'nullable|string',
            ]);

            Log::info('Banner validation passed');

            // Validate video source requirements
            $validationError = $this->validateVideoSource($request);
            if ($validationError) {
                return $validationError;
            }

            $data = $request->only(['main_content', 'car_id', 'title', 'position', 'click_url']);

            // Correctly handle is_active field (will be either 1 or 0 from hidden input)
            $data['is_active'] = $request->input('is_active', 0);

            Log::info('Processing banner data', [
                'data' => $data,
                'is_active_value' => $data['is_active'],
                'original_is_active' => $request->input('is_active')
            ]);

            // Handle video based on type
            if ($request->video_type === 'upload' && $request->hasFile('video')) {
                $videoFile = $request->file('video');

                // Log debugging information
                Log::info('Video upload information', [
                    'original_name' => $videoFile->getClientOriginalName(),
                    'size' => $videoFile->getSize(),
                    'mime_type' => $videoFile->getMimeType(),
                    'is_valid' => $videoFile->isValid(),
                    'upload_error' => $videoFile->getError(),
                    'php_ini_settings' => [
                        'upload_max_filesize' => ini_get('upload_max_filesize'),
                        'post_max_size' => ini_get('post_max_size'),
                        'memory_limit' => ini_get('memory_limit')
                    ]
                ]);

                try {
                    // Ensure storage directory exists
                    $uploadPath = 'public/videos';
                    Log::info('Checking if storage directory exists', ['path' => $uploadPath]);

                    if (!Storage::exists($uploadPath)) {
                        Log::info('Creating storage directory', ['path' => $uploadPath]);
                        Storage::makeDirectory($uploadPath);
                    }

                    // Create a unique filename
                    $filename = Str::random(20) . '.' . $videoFile->getClientOriginalExtension();
                    Log::info('Generated filename', ['filename' => $filename]);

                    // Store the file in the storage/app/public/videos directory
                    Log::info('Attempting to store file', [
                        'source' => 'upload',
                        'destination_path' => 'videos/' . $filename,
                        'disk' => 'public'
                    ]);

                    $path = $videoFile->storeAs('videos', $filename, 'public');

                    if ($path) {
                        $data['video_url'] = $path;
                        Log::info('Video uploaded successfully', ['path' => $path]);
                    } else {
                        Log::error('Failed to store video file - path is empty');
                        return redirect()->back()
                            ->withInput()
                            ->with('error', 'Error uploading video: file could not be saved.')
                            ->withErrors(['video' => 'Failed to upload video. Please try again.']);
                    }
                } catch (\Exception $e) {
                    Log::error('Exception when uploading video', [
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);

                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Error uploading video: ' . $e->getMessage())
                        ->withErrors(['video' => 'Error uploading video: ' . $e->getMessage()]);
                }
            } elseif ($request->video_type === 'existing' && $request->filled('existing_video')) {
                // Using existing video from public folder
                $data['video_url'] = 'videos/' . $request->existing_video; // Store path relative to public
                Log::info('Using existing video', ['video_url' => $data['video_url']]);
            }

            Log::info('Creating banner record', ['data' => $data]);
            $banner = Banner::create($data);
            Log::info('Banner created successfully', ['banner_id' => $banner->id]);

            // Log the activity
            \App\Services\ActivityLogService::log(
                'create',
                'banners',
                $banner->id,
                [
                    'title' => $banner->title
                ]
            );

            return redirect()->route('admin.banners.index')
                ->with('success', 'Banner created successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation exception', [
                'errors' => $e->errors(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Unexpected exception in banner store', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'An unexpected error occurred: ' . $e->getMessage())
                ->withErrors(['error' => 'An unexpected error occurred: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified banner.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        $cars = Car::where('isActive', true)->get();
        return view('admin.banners.edit', compact('banner', 'cars'));
    }

    /**
     * Update the specified banner in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        Log::info('Banner update method called', ['request_data' => $request->all()]);

        $request->validate([
            'main_content' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:100',
            'position' => 'nullable|integer|min:0',
            'car_id' => 'nullable|exists:cars,id',
            'click_url' => 'nullable|string|max:255',
            'video_type' => 'required|in:upload,existing,keep',
            'video' => 'nullable|file|mimes:mp4,mov,avi|max:1048576', // 1GB (1024 * 1024 KB)
            'existing_video' => 'nullable|string',
        ]);

        // Validate video source requirements if not keeping current video
        if ($request->video_type !== 'keep') {
            $validationError = $this->validateVideoSource($request, $banner);
            if ($validationError) {
                return $validationError;
            }
        }

        $data = $request->only(['main_content', 'car_id', 'title', 'position', 'click_url']);

        // Correctly handle is_active field (will be either 1 or 0 from hidden input)
        $data['is_active'] = $request->input('is_active', 0);

        Log::info('Processing banner update data', [
            'data' => $data,
            'is_active_value' => $data['is_active'],
            'original_is_active' => $request->input('is_active')
        ]);

        // Handle video based on type
        if ($request->video_type === 'upload' && $request->hasFile('video')) {
            $videoFile = $request->file('video');

            // Log debugging information
            Log::info('Video update information', [
                'original_name' => $videoFile->getClientOriginalName(),
                'size' => $videoFile->getSize(),
                'mime_type' => $videoFile->getMimeType(),
                'is_valid' => $videoFile->isValid(),
                'upload_error' => $videoFile->getError()
            ]);

            try {
                // Delete old video if exists and not a reference to public videos
                if ($banner->video_url && !str_starts_with($banner->video_url, 'videos/')) {
                    Storage::disk('public')->delete($banner->video_url);
                }

                // Ensure storage directory exists
                $uploadPath = 'public/videos';
                if (!Storage::exists($uploadPath)) {
                    Storage::makeDirectory($uploadPath);
                }

                // Create a unique filename
                $filename = Str::random(20) . '.' . $videoFile->getClientOriginalExtension();

                // Store the file in the storage/app/public/videos directory
                $path = $videoFile->storeAs('videos', $filename, 'public');

                if ($path) {
                    $data['video_url'] = $path;
                    Log::info('Video updated successfully', ['path' => $path]);
                } else {
                    Log::error('Failed to store video file during update');
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Error uploading video: file could not be saved.')
                        ->withErrors(['video' => 'Failed to upload video. Please try again.']);
                }
            } catch (\Exception $e) {
                Log::error('Exception when updating video', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Error uploading video: ' . $e->getMessage())
                    ->withErrors(['video' => 'Error uploading video: ' . $e->getMessage()]);
            }
        } elseif ($request->video_type === 'existing' && $request->filled('existing_video')) {
            // Using existing video from public folder
            $data['video_url'] = 'videos/' . $request->existing_video; // Store path relative to public
        }
        // If video_type is 'keep', we don't update the video_url field

        // Store original data for logging
        $originalData = $banner->toArray();

        $banner->update($data);

        // Log the activity
        \App\Services\ActivityLogService::log(
            'update',
            'banners',
            $banner->id,
            [
                'changed_fields' => array_keys(array_diff_assoc($data, array_intersect_key($originalData, $data))),
                'title' => $banner->title
            ]
        );

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner updated successfully');
    }

    /**
     * Remove the specified banner from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        // Delete associated video file if exists and not a reference to public videos
        if ($banner->video_url && !str_starts_with($banner->video_url, 'videos/')) {
            Storage::disk('public')->delete($banner->video_url);
        }

        // Store banner info before deletion for logging
        $bannerInfo = [
            'id' => $banner->id,
            'title' => $banner->title,
            'position' => $banner->position
        ];

        $banner->delete();

        // Log the activity
        \App\Services\ActivityLogService::log(
            'delete',
            'banners',
            $bannerInfo['id'],
            $bannerInfo
        );

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully');
    }

    /**
     * Validate depending on video source for update method
     */
    protected function validateVideoSource(Request $request, Banner $banner = null)
    {
        // Skip validation if keeping the current video
        if ($request->video_type === 'keep') {
            return null;
        }

        if ($request->video_type === 'upload' && !$request->hasFile('video')) {
            Log::warning('Video type is upload but no file was provided');
            return redirect()->back()
                ->withInput()
                ->with('error', 'Please upload a video file.')
                ->withErrors(['video' => 'Please upload a video file.']);
        }

        if ($request->video_type === 'existing' && !$request->filled('existing_video')) {
            Log::warning('Video type is existing but no existing video was selected');
            return redirect()->back()
                ->withInput()
                ->with('error', 'Please select an existing video.')
                ->withErrors(['video' => 'Please select an existing video.']);
        }

        return null; // Validation passed
    }
}
