<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts.
     */
    public function index()
    {
        // Get published blog posts
        $posts = BlogPost::with('author')
                        ->published()
                        ->orderBy('published_at', 'desc')
                        ->paginate(10);

        // Get all categories for sidebar
        $categories = BlogPost::published()
                            ->select('category')
                            ->distinct()
                            ->pluck('category')
                            ->filter()
                            ->map(function ($category) {
                                $count = BlogPost::published()->where('category', $category)->count();
                                return ['name' => $category, 'count' => $count];
                            })
                            ->sortByDesc('count');

        return view('blog', compact('posts', 'categories'));
    }

    /**
     * Display the specified blog post.
     */
    public function show(string $slug)
    {
        $post = BlogPost::where('slug', $slug)
                       ->with('author')
                       ->firstOrFail();

        // Check if post is published or user is author/admin/content
        if (!$post->isPublished() &&
            !(Auth::check() && (Auth::id() === $post->user_id ||
                               Auth::user()->isAdmin() ||
                               Auth::user()->isContent()))) {
            abort(404);
        }

        // Get recent posts for sidebar
        $recentPosts = BlogPost::published()
                             ->where('id', '!=', $post->id)
                             ->latest('published_at')
                             ->take(5)
                             ->get();

        // Tạo dữ liệu để hiển thị trong template
        $postData = [
            'title' => $post->title,
            'slug' => $post->slug,
            'author' => $post->author->name ?? 'Unknown Author',
            'date' => $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y'),
            'category' => $post->category,
            'tags' => is_string($post->tags) ? explode(',', $post->tags) : (is_array($post->tags) ? $post->tags : []),
            'image' => $post->featured_image ? asset('storage/' . $post->featured_image) : asset('images/blog/default.jpg'),
            'content' => $post->content, // Không cần xử lý thêm vì blade template sẽ xử lý với {!! !!}
        ];

        // Recent posts cho sidebar
        $recentPostsData = $recentPosts->map(function($recentPost) {
            return [
                'slug' => $recentPost->slug,
                'title' => $recentPost->title,
                'date' => $recentPost->published_at ? $recentPost->published_at->format('M d, Y') : $recentPost->created_at->format('M d, Y'),
            ];
        });

        return view('blog_post', [
            'post' => $postData,
            'recentPosts' => $recentPostsData,
        ]);
    }
}
