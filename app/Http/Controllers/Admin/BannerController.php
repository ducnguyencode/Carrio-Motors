<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Car;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $this->middleware('admin');
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of the banners.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::with('car')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new banner.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cars = Car::where('is_active', true)->get();
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
        $request->validate([
            'main_content' => 'required|string|max:255',
            'car_id' => 'required|exists:cars,id',
            'video' => 'nullable|file|mimes:mp4,mov,avi|max:102400', // 100MB max
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['main_content', 'car_id']);
        $data['is_active'] = $request->has('is_active');

        // Handle video upload
        if ($request->hasFile('video')) {
            $videoPath = $this->fileUploadService->uploadVideo($request->file('video'));
            if ($videoPath) {
                $data['video_url'] = $videoPath;
            }
        }

        Banner::create($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner created successfully');
    }

    /**
     * Show the form for editing the specified banner.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        $cars = Car::where('is_active', true)->get();
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
        $request->validate([
            'main_content' => 'required|string|max:255',
            'car_id' => 'required|exists:cars,id',
            'video' => 'nullable|file|mimes:mp4,mov,avi|max:102400', // 100MB max
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['main_content', 'car_id']);
        $data['is_active'] = $request->has('is_active');

        // Handle video upload
        if ($request->hasFile('video')) {
            // Delete old video if exists
            if ($banner->video_url) {
                $this->fileUploadService->deleteFile($banner->video_url);
            }

            $videoPath = $this->fileUploadService->uploadVideo($request->file('video'));
            if ($videoPath) {
                $data['video_url'] = $videoPath;
            }
        }

        $banner->update($data);

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
        // Delete associated video file if exists
        if ($banner->video_url) {
            $this->fileUploadService->deleteFile($banner->video_url);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully');
    }
}
