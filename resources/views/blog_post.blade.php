@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $post['title'] }}</li>
        </ol>
    </nav>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <!-- Post Header -->
            <div class="mb-4">
                <h1 class="display-5 fw-bold">{{ $post['title'] }}</h1>
                <div class="d-flex align-items-center text-muted mb-4">
                    <i class="bi bi-person-circle me-1"></i> {{ $post['author'] }}
                    <span class="mx-2">|</span>
                    <i class="bi bi-calendar3 me-1"></i> {{ $post['date'] }}
                    <span class="mx-2">|</span>
                    <span class="badge bg-primary">{{ $post['category'] }}</span>
                </div>
            </div>

            <!-- Featured Image -->
            <div class="mb-4">
                <img src="{{ asset($post['image']) }}" class="img-fluid rounded w-100" alt="{{ $post['title'] }}" style="max-height: 500px; object-fit: cover;">
            </div>

            <!-- Post Content -->
            <div class="blog-content mb-5">
                {!! $post['content'] !!}
            </div>

            <!-- Tags -->
            <div class="blog-tags mb-5">
                <h5>Tags</h5>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    @foreach($post['tags'] as $tag)
                    <a href="#" class="badge bg-light text-dark text-decoration-none p-2">#{{ $tag }}</a>
                    @endforeach
                </div>
            </div>

            <!-- Post Navigation -->
            <div class="blog-navigation border-top border-bottom py-4 mb-5">
                <div class="row">
                    <div class="col-6">
                        <div class="blog-prev text-start">
                            <span class="text-muted small d-block">Previous Post</span>
                            <a href="#" class="text-decoration-none text-primary">Luxury Car Buying Guide</a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="blog-next text-end">
                            <span class="text-muted small d-block">Next Post</span>
                            <a href="#" class="text-decoration-none text-primary">Essential Car Maintenance Tips</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="row mt-4 mb-5">
        <div class="col-12">
            <h3 class="mb-4">Recent Posts</h3>
            <div class="row">
                @foreach($recentPosts as $recentPost)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light rounded-circle p-3 me-3">
                                    <i class="bi bi-file-text text-primary fs-4"></i>
                                </div>
                                <h5 class="card-title mb-0">{{ $recentPost['title'] }}</h5>
                            </div>
                            <p class="card-text text-muted small">{{ $recentPost['date'] }}</p>
                            <a href="{{ route('blog.post', $recentPost['slug']) }}" class="btn btn-sm btn-outline-primary">Read Article</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="row">
        <div class="col-12">
            <div class="blog-comments mb-5">
                <h3 class="mb-4">Comments <span class="text-muted">(3)</span></h3>

                <!-- Comment Item -->
                <div class="comment-item mb-4 pb-4 border-bottom">
                    <div class="d-flex">
                        <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="User Avatar">
                        <div class="flex-grow-1">
                            <h5 class="mb-1">John Smith</h5>
                            <span class="text-muted small">Posted on {{ $post['date'] }}</span>
                            <p class="mt-2">This is a fantastic post! I've been considering an electric vehicle, and this list gives me a great starting point. The Hyundai Ioniq 5 caught my attention with its unique design.</p>
                            <button class="btn btn-sm btn-link text-decoration-none p-0">Reply</button>
                        </div>
                    </div>
                </div>

                <!-- Comment Item -->
                <div class="comment-item mb-4 pb-4 border-bottom">
                    <div class="d-flex">
                        <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="User Avatar">
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Sarah Johnson</h5>
                            <span class="text-muted small">Posted on {{ $post['date'] }}</span>
                            <p class="mt-2">I recently test drove the Ford Mustang Mach-E, and I have to agree with your assessment. The performance is impressive, and the range is more than adequate for my daily commute.</p>
                            <button class="btn btn-sm btn-link text-decoration-none p-0">Reply</button>
                        </div>
                    </div>
                </div>

                <!-- Comment Item -->
                <div class="comment-item mb-4">
                    <div class="d-flex">
                        <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="User Avatar">
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Mike Thompson</h5>
                            <span class="text-muted small">Posted on {{ $post['date'] }}</span>
                            <p class="mt-2">What about the Lucid Air? I think it deserves a spot on this list with its industry-leading range and performance. Any thoughts on how it compares to the Mercedes EQS?</p>
                            <button class="btn btn-sm btn-link text-decoration-none p-0">Reply</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comment Form -->
            <div class="blog-comment-form mb-5">
                <h3 class="mb-4">Leave a Comment</h3>
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <input type="text" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control" placeholder="Your Email" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" rows="5" placeholder="Your Comment" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .blog-content {
        line-height: 1.8;
    }

    .blog-content h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .blog-content p {
        margin-bottom: 1.5rem;
    }

    .blog-content ul {
        margin-bottom: 1.5rem;
    }
</style>
@endpush
