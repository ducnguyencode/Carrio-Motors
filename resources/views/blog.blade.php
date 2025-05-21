@extends('layouts.app')

@section('content')
<!-- Hero Section with Parallax Effect -->
<div class="blog-hero position-relative overflow-hidden">
    <div class="parallax-bg" style="background-image: url('{{ asset('images/blog/blog-hero.jpg') }}');"></div>
    <div class="hero-content container d-flex flex-column justify-content-center">
        <h1 class="display-3 fw-bold text-white text-center mb-2">Carrio Motors Blog</h1>
        <p class="lead text-white text-center mb-0">Latest news, reviews, and insights from the automotive world</p>
    </div>
</div>

<div class="container py-5">
    <!-- Featured Post -->
    @if($posts->isNotEmpty())
    <div class="featured-post mb-5">
        @php
            $featuredPost = $posts->first();
        @endphp
        <div class="row g-0 bg-white shadow-sm rounded-4 overflow-hidden">
            <div class="col-lg-6">
                <div class="featured-image h-100">
                    <img src="{{ $featuredPost->featured_image ? asset('storage/' . $featuredPost->featured_image) : asset('images/blog/default.jpg') }}"
                         alt="{{ $featuredPost->title }}" class="w-100 h-100 object-cover">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-4 p-lg-5 d-flex flex-column h-100">
                    <div class="mb-3">
                        @if($featuredPost->category)
                        <span class="badge bg-primary">{{ $featuredPost->category }}</span>
                        @endif
                        <span class="text-muted ms-2"><i class="far fa-calendar-alt me-1"></i> {{ $featuredPost->formatted_date }}</span>
                    </div>
                    <h2 class="h1 fw-bold mb-3">{{ $featuredPost->title }}</h2>
                    <p class="text-muted flex-grow-1">{{ $featuredPost->excerpt }}</p>
                    <div class="mt-3">
                        <a href="{{ route('blog.post', $featuredPost->slug) }}" class="btn btn-primary">
                            Read Article <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Latest Articles -->
    <div class="row">
        <div class="col-12">
            <h2 class="h3 fw-bold mb-4">Latest Articles</h2>

            <div class="row">
                @foreach($posts as $index => $post)
                    @if($index > 0) <!-- Skip the first post (featured) -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm h-100 post-card">
                            <div class="post-image">
                                <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : asset('images/blog/default.jpg') }}"
                                     class="card-img-top" alt="{{ $post->title }}">
                                @if($post->category)
                                <span class="category-badge">{{ $post->category }}</span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="post-meta mb-2">
                                    <span class="text-muted small">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $post->formatted_date }}
                                    </span>
                                    <span class="ms-3 text-muted small">
                                        <i class="far fa-clock me-1"></i> {{ $post->reading_time }} min read
                                    </span>
                                </div>
                                <h3 class="card-title h5 fw-bold">{{ $post->title }}</h3>
                                <p class="card-text text-muted flex-grow-1">{{ Str::limit($post->excerpt, 100) }}</p>
                                <a href="{{ route('blog.post', $post->slug) }}" class="text-decoration-none text-primary mt-2">
                                    Read more <i class="fas fa-arrow-right ms-1 small"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            <!-- Pagination with modern styling -->
            <div class="d-flex justify-content-center mt-5 mb-5">
                {{ $posts->links() }}
            </div>
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="row mt-4">
        <div class="col-12">
            <h2 class="h3 fw-bold mb-4">Recent Posts</h2>
            <div class="row">
                @foreach($posts->take(3) as $recentPost)
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 me-3" style="width: 60px; height: 60px; overflow: hidden; border-radius: 4px;">
                                    <img src="{{ $recentPost->featured_image ? asset('storage/' . $recentPost->featured_image) : asset('images/blog/default.jpg') }}"
                                        alt="{{ $recentPost->title }}" class="w-100 h-100 object-cover">
                                </div>
                                <div>
                                    <h5 class="card-title mb-1">{{ Str::limit($recentPost->title, 50) }}</h5>
                                    <div class="small text-muted">{{ $recentPost->formatted_date }}</div>
                                </div>
                            </div>
                            <a href="{{ route('blog.post', $recentPost->slug) }}" class="btn btn-sm btn-outline-primary">Read Article</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection

@push('styles')
<style>
    /* Hero styles */
    .blog-hero {
        height: 400px;
        color: white;
    }

    .parallax-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        filter: brightness(0.5);
    }

    .hero-content {
        position: relative;
        z-index: 1;
        height: 100%;
    }

    /* Card styles */
    .post-card {
        transition: all 0.3s ease;
        border-radius: 8px;
        overflow: hidden;
    }

    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .post-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .post-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .post-card:hover .post-image img {
        transform: scale(1.05);
    }

    .category-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: var(--primary-color);
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    /* Featured post */
    .featured-post .featured-image {
        height: 100%;
        min-height: 400px;
    }

    .object-cover {
        object-fit: cover;
    }

    @media (max-width: 991px) {
        .featured-post .featured-image {
            min-height: 300px;
        }
    }
</style>
@endpush
