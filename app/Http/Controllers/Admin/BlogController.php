<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,content');
    }

    /**
     * Display a listing of the resource in admin panel.
     */
    public function index(Request $request)
    {
        $query = BlogPost::with('author')->latest();

        // Apply status filter if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Get different results based on user role
        if (!Auth::user()->isAdmin()) {
            // Content managers can only see their own posts
            $query->where('user_id', Auth::id());
        }

        $posts = $query->paginate(15)->withQueryString();

        return view('admin.blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'category' => 'nullable|max:100',
            'tags' => 'nullable',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
        ]);

        // Handle slug
        $slug = Str::slug($request->title);
        $uniqueSlug = $slug;
        $counter = 1;

        // Ensure slug is unique
        while (BlogPost::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $slug . '-' . $counter;
            $counter++;
        }

        // Handle tags
        $tags = null;
        if ($request->has('tags') && !empty($request->tags)) {
            $tags = explode(',', $request->tags);
            $tags = array_map('trim', $tags);
        }

        // Handle featured image
        $featuredImage = null;
        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image')->store('blog', 'public');
        }

        // Set published_at date if status is published
        $publishedAt = null;
        if ($request->status === 'published') {
            $publishedAt = now();
        }

        // Create blog post
        $post = BlogPost::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => $uniqueSlug,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'featured_image' => $featuredImage,
            'category' => $request->category,
            'tags' => $tags,
            'status' => $request->status,
            'published_at' => $publishedAt,
        ]);

        return redirect()->route('admin.blog.index')
                        ->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = BlogPost::findOrFail($id);

        // Check if user is author or admin
        if (Auth::id() !== $post->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.blog.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = BlogPost::findOrFail($id);

        // Check if user is author or admin
        if (Auth::id() !== $post->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'category' => 'nullable|max:100',
            'tags' => 'nullable',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
        ]);

        // Handle slug if title has changed
        if ($request->title !== $post->title) {
            $slug = Str::slug($request->title);
            $uniqueSlug = $slug;
            $counter = 1;

            // Ensure slug is unique
            while (BlogPost::where('slug', $uniqueSlug)->where('id', '!=', $id)->exists()) {
                $uniqueSlug = $slug . '-' . $counter;
                $counter++;
            }

            $post->slug = $uniqueSlug;
        }

        // Handle tags
        if ($request->has('tags')) {
            $tags = explode(',', $request->tags);
            $tags = array_map('trim', $tags);
            $post->tags = $tags;
        }

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }

            $post->featured_image = $request->file('featured_image')->store('blog', 'public');
        }

        // Set published_at date if status is published and post wasn't published before
        if ($request->status === 'published' && $post->status !== 'published') {
            $post->published_at = now();
        }

        // Update post fields
        $post->title = $request->title;
        $post->excerpt = $request->excerpt;
        $post->content = $request->content;
        $post->category = $request->category;
        $post->status = $request->status;
        $post->save();

        return redirect()->route('admin.blog.index')
                        ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = BlogPost::findOrFail($id);

        // Check if user is author or admin
        if (Auth::id() !== $post->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete featured image if exists
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('admin.blog.index')
                        ->with('success', 'Blog post deleted successfully!');
    }

    /**
     * Change post status (published, draft, archived).
     */
    public function changeStatus(Request $request, string $id)
    {
        $post = BlogPost::findOrFail($id);

        // Check if user is author or admin
        if (Auth::id() !== $post->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:published,draft,archived',
        ]);

        // Set published_at date if status is published and post wasn't published before
        if ($request->status === 'published' && $post->status !== 'published') {
            $post->published_at = now();
        }

        $post->status = $request->status;
        $post->save();

        return redirect()->route('admin.blog.index')
                        ->with('success', 'Blog post status updated successfully!');
    }

    /**
     * Handle image upload from CKEditor
     */
    public function uploadImage(Request $request)
    {
        if (!$request->hasFile('upload')) {
            \Illuminate\Support\Facades\Log::error('CKEditor upload error: No file uploaded');

            return response()->json([
                'error' => [
                    'message' => 'No file was uploaded.'
                ]
            ], 400);
        }

        $file = $request->file('upload');

        // Validate file
        $validator = validator()->make(
            ['upload' => $file],
            ['upload' => 'required|image|max:2048'] // 2MB max, image files only
        );

        if ($validator->fails()) {
            \Illuminate\Support\Facades\Log::error('CKEditor upload validation error', [
                'errors' => $validator->errors()->first('upload')
            ]);

            return response()->json([
                'error' => [
                    'message' => $validator->errors()->first('upload')
                ]
            ], 422);
        }

        try {
            // Generate a unique name for the file
            $fileName = uniqid() . '_' . $file->getClientOriginalName();

            // Ensure the storage directory exists
            $uploadPath = 'public/blog/content';
            if (!Storage::exists($uploadPath)) {
                Storage::makeDirectory($uploadPath);
            }

            // Store the file
            $path = $file->storeAs('blog/content', $fileName, 'public');
            $url = asset('storage/' . $path);

            // Debug information
            \Illuminate\Support\Facades\Log::info('CKEditor image uploaded successfully', [
                'fileName' => $fileName,
                'path' => $path,
                'url' => $url,
                'storage_path' => Storage::path($uploadPath)
            ]);

            // Return response for CKEditor
            return response()->json([
                'uploaded' => 1,
                'fileName' => $fileName,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('CKEditor upload error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => 'Error uploading image: ' . $e->getMessage()
                ]
            ], 500);
        }
    }
}
