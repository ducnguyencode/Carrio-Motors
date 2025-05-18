@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success mt-4" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="container mt-4 relative search-container">
    <input
        id="search-input"
        type="text"
        class="form-control"
        placeholder="Search cars by name or brand..."
        onfocus="this.select();"
    >
    <ul id="search-results" class="list-group position-absolute w-100 z-10" style="max-height: 200px; overflow-y: auto;"></ul>
</div>

<div class="video-carousel">
    <div class="carousel-slide active">
        <video class="background-video" autoplay muted loop playsinline>
            <source src="{{ asset('videos/video1.mp4') }}" type="video/mp4">
        </video>
        <div class="carousel-content">
            <h1>Car 1</h1>
            <h4>Luxury meets performance</h4>
        </div>
    </div>
    <div class="carousel-slide">
        <video class="background-video" autoplay muted loop playsinline>
            <source src="{{ asset('videos/video2.mp4') }}" type="video/mp4">
        </video>
        <div class="carousel-content">
            <h1>Car 2</h1>
            <h4>Style and speed combined</h4>
        </div>
    </div>
    <div class="carousel-slide">
        <video class="background-video" autoplay muted loop playsinline>
            <source src="{{ asset('videos/video3.mp4') }}" type="video/mp4">
        </video>
        <div class="carousel-content">
            <h1>Car 3</h1>
            <h4>Innovation on wheels</h4>
        </div>
    </div>

    <div class="carousel-indicators">
        <div class="dot active"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</div>

<h1 class="mt-5">Welcome to Carrio Motors</h1>
<p>Explore top brands like BMW, Audi, Hyundai, JEEP, Suzuki, and more!</p>
<img src="/images/banner.jpg" alt="Car Banner" class="img-fluid">

<h2 class="text-center fw-bold mb-4">Featured Cars</h2>

<div class="row g-4" id="product-list">
    @foreach($featuredCars as $index => $car)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 product-card {{ $index >= 4 ? 'd-none' : '' }}">
            <div
                class="card h-100 shadow-sm cursor-pointer"
                onclick="openCarPopup(@json($car))"
            >
                <img src="{{ $car['image_url'] }}" class="card-img-top" alt="{{ $car['name'] }}" style="height: 180px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $car['name'] }}</h5>
                    <div class="mb-2">
                        <span class="text-warning fw-bold">{{ number_format($car['rating'], 1) }}</span>
                        <span class="text-warning">⭐</span>
                        <small class="text-muted">({{ $car['reviews'] }} reviews)</small>
                    </div>
                    @if($car['is_best_seller'])
                        <span class="badge bg-success mb-2">Best Seller</span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="text-center mt-4">
    <button id="show-more-btn" class="btn btn-primary">Show more products</button>
</div>

<script>
    document.getElementById('show-more-btn').addEventListener('click', function () {
        document.querySelectorAll('.product-card.d-none').forEach(function (card) {
            card.classList.remove('d-none');
        });
        this.style.display = 'none';
    });
</script>

{{-- Modal popup --}}
<div id="carModal" class="modal fade" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="carName"></h5>
        <button type="button" class="btn-close" onclick="closeCarPopup()"></button>
      </div>
      <div class="modal-body">
        <img id="carImage" src="" class="img-fluid mb-3" style="max-height: 300px; object-fit: cover;">
        <p><strong>Price:</strong> $<span id="carPrice"></span></p>
        <p><strong>Rating:</strong> <span id="carRating"></span> ⭐</p>
        <p><strong>Reviews:</strong> <span id="carReviews"></span> reviews</p>
        <h6>Specifications:</h6>
        <ul class="list-group">
          <li class="list-group-item"><strong>Engine:</strong> <span id="carEngine"></span></li>
          <li class="list-group-item"><strong>Fuel Type:</strong> <span id="carFuelType"></span></li>
          <li class="list-group-item"><strong>Transmission:</strong> <span id="carTransmission"></span></li>
          <li class="list-group-item"><strong>Seats:</strong> <span id="carSeats"></span></li>
          <li class="list-group-item"><strong>Color:</strong> <span id="carColor"></span></li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
    function openCarPopup(car) {
        document.getElementById('carName').innerText = car.name;
        document.getElementById('carImage').src = car.image_url;
        document.getElementById('carPrice').innerText = car.price ?? 'Updating';
        document.getElementById('carRating').innerText = parseFloat(car.rating).toFixed(1);
        document.getElementById('carReviews').innerText = car.reviews;

        document.getElementById('carEngine').innerText = car.engine ?? 'N/A';
        document.getElementById('carFuelType').innerText = car.fuel_type ?? 'N/A';
        document.getElementById('carTransmission').innerText = car.transmission ?? 'N/A';
        document.getElementById('carSeats').innerText = car.seats ?? 'N/A';
        document.getElementById('carColor').innerText = car.color ?? 'N/A';

        new bootstrap.Modal(document.getElementById('carModal')).show();
    }

    function closeCarPopup() {
        bootstrap.Modal.getInstance(document.getElementById('carModal')).hide();
    }
        let lastClickedCard = null;
    let clickTimer = null;

    document.querySelectorAll('.car-card').forEach(card => {
        card.addEventListener('click', function () {
            const carId = this.dataset.carId;
            const carData = JSON.parse(this.dataset.carJson);

            if (lastClickedCard === this) {
                clearTimeout(clickTimer);
                lastClickedCard = null;
                window.location.href = `/cars/${carId}`;
            } else {
                lastClickedCard = this;

                clickTimer = setTimeout(() => {
                    openCarPopup(carData);
                    lastClickedCard = null;
                }, 600);
            }
        });
    });
</script>
@endpush
