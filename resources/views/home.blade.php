@extends('layouts.app')

@section('styles')
<style>
    .video-link {
        display: block;
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }

    .video-link:hover .carousel-content {
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
    }
</style>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success mt-4" role="alert">
        {{ session('success') }}
    </div>
@endif
<div class="video-carousel">
    @forelse($banners as $index => $banner)
    <div class="carousel-slide {{ $index === 0 ? 'active' : '' }}">
        <a href="{{ $banner->click_url ?? ($banner->car_id ? route('cars', ['id' => $banner->car_id]) : '#') }}" class="video-link">
            <video class="background-video" autoplay muted loop playsinline>
                <source src="{{ Storage::url($banner->video_url) }}" type="video/mp4">
            </video>
            <div class="carousel-content">
                <h1>{{ $banner->title }}</h1>
                <h4>{{ $banner->main_content }}</h4>
            </div>
        </a>
    </div>
    @empty
    <!-- Fallback to default videos if no banners in database -->
    <div class="carousel-slide active">
        <a href="#" class="video-link">
            <video class="background-video" autoplay muted loop playsinline>
                <source src="{{ asset('videos/video1.mp4') }}" type="video/mp4">
            </video>
            <div class="carousel-content">
                <h1>Car 1</h1>
                <h4>Luxury meets performance</h4>
            </div>
        </a>
    </div>
    <div class="carousel-slide">
        <a href="#" class="video-link">
            <video class="background-video" autoplay muted loop playsinline>
                <source src="{{ asset('videos/video2.mp4') }}" type="video/mp4">
            </video>
            <div class="carousel-content">
                <h1>Car 2</h1>
                <h4>Style and speed combined</h4>
            </div>
        </a>
    </div>
    <div class="carousel-slide">
        <a href="#" class="video-link">
            <video class="background-video" autoplay muted loop playsinline>
                <source src="{{ asset('videos/video3.mp4') }}" type="video/mp4">
            </video>
            <div class="carousel-content">
                <h1>Car 3</h1>
                <h4>Innovation on wheels</h4>
            </div>
        </a>
    </div>
    @endforelse

    <div class="carousel-indicators">
        @if($banners->count() > 0)
            @foreach($banners as $index => $banner)
            <div class="dot {{ $index === 0 ? 'active' : '' }}"></div>
            @endforeach
        @else
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        @endif
    </div>
</div>

<h1 class="mt-5">Welcome to Carrio Motors</h1>
<p>Explore top brands like BMW, Audi, Hyundai, JEEP, Suzuki, and more!</p>
<img src="/images/banner.jpg" alt="Car Banner" class="img-fluid">
@endsection
