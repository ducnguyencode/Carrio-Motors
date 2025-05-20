@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Blog</li>
        </ol>
    </nav>

    <!-- Blog Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card bg-dark text-white border-0 rounded-3 overflow-hidden position-relative">
                <img src="{{ asset('images/blog/blog-header.jpg') }}" class="card-img opacity-50" alt="Car Blog" style="height: 300px; object-fit: cover;">
                <div class="card-img-overlay d-flex flex-column justify-content-center text-center">
                    <h1 class="card-title display-4 fw-bold">Carrio Motors Blog</h1>
                    <p class="card-text fs-5 mb-4">Stay informed with the latest automotive news, tips, and insights</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Blog Posts -->
        <div class="col-lg-8">
            <div class="row">
                @foreach($posts as $post)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="position-relative">
                            <img src="{{ asset($post['image']) }}" class="card-img-top" alt="{{ $post['title'] }}" style="height: 200px; object-fit: cover;">
                            <span class="position-absolute top-0 start-0 bg-primary text-white py-1 px-2 m-2 rounded-pill small">{{ $post['category'] }}</span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $post['title'] }}</h5>
                            <div class="d-flex align-items-center text-muted small mb-3">
                                <i class="bi bi-person-circle me-1"></i> {{ $post['author'] }}
                                <span class="mx-2">|</span>
                                <i class="bi bi-calendar3 me-1"></i> {{ $post['date'] }}
                            </div>
                            <p class="card-text">{{ $post['excerpt'] }}</p>
                            <div class="mt-auto">
                                <div class="d-flex flex-wrap gap-1 mb-3">
                                    @foreach($post['tags'] as $tag)
                                    <span class="badge bg-light text-dark">#{{ $tag }}</span>
                                    @endforeach
                                </div>
                                <a href="{{ route('blog.post', $post['slug']) }}" class="btn btn-outline-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <nav class="mt-4 d-flex justify-content-center">
                <ul class="pagination">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Search Widget -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Search</h5>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for articles...">
                        <button class="btn btn-primary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Categories Widget -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Categories</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($categories as $category => $count)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <a href="#" class="text-decoration-none text-dark">{{ $category }}</a>
                            <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Featured Post Widget -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Featured Post</h5>
                    <div class="position-relative mb-3">
                        <img src="{{ asset($posts[0]['image']) }}" class="img-fluid rounded" alt="{{ $posts[0]['title'] }}">
                        <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-dark bg-opacity-75 text-white">
                            <h6 class="mb-0">{{ $posts[0]['title'] }}</h6>
                        </div>
                    </div>
                    <p class="small">{{ $posts[0]['excerpt'] }}</p>
                    <a href="{{ route('blog.post', $posts[0]['slug']) }}" class="btn btn-sm btn-outline-primary">Read More</a>
                </div>
            </div>

            <!-- Popular Tags Widget -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Popular Tags</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#" class="badge bg-light text-dark text-decoration-none p-2">#Electric</a>
                        <a href="#" class="badge bg-light text-dark text-decoration-none p-2">#Luxury</a>
                        <a href="#" class="badge bg-light text-dark text-decoration-none p-2">#SUV</a>
                        <a href="#" class="badge bg-light text-dark text-decoration-none p-2">#Maintenance</a>
                        <a href="#" class="badge bg-light text-dark text-decoration-none p-2">#Tesla</a>
                        <a href="#" class="badge bg-light text-dark text-decoration-none p-2">#Sports</a>
                        <a href="#" class="badge bg-light text-dark text-decoration-none p-2">#Family</a>
                        <a href="#" class="badge bg-light text-dark text-decoration-none p-2">#Technology</a>
                        <a href="#" class="badge bg-light text-dark text-decoration-none p-2">#Future</a>
                        <a href="#" class="badge bg-light text-dark text-decoration-none p-2">#Hybrid</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }

    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endpush
