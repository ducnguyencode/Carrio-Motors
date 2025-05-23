@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Featured Cars</h2>
    <div class="row g-4">
        @forelse($cars as $car)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100" onclick="window.location.href='{{ route('car.detail', ['id' => $car->id]) }}'">
                <img src="{{ $car->image_url }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $car->name }}</h5>
                    <div class="text-warning mb-2">
                        {{ number_format($car->rating, 1) }} ⭐ ({{ $car->reviews }} reviews)
                    </div>
                    @if($car->is_best_seller)
                        <span class="badge bg-success">Best Seller</span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p>No featured cars found.</p>
        @endforelse
    </div>

    <div class="mt-4">
        @include('components.modern-pagination', ['paginator' => $cars, 'elements' => $cars->links()->elements])
    </div>
</div>
@endsection
