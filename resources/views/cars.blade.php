@extends('layouts.app')
@section('content')
<h2>Available Cars</h2>
<div class="row">
    @foreach ($cars as $car)
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="{{ $car->image_url }}" class="card-img-top" alt="{{ $car->name }}">
            <div class="card-body">
                <h5 class="card-title">{{ $car->name }}</h5>
                <p class="card-text">Brand: {{ $car->brand }} | Seats: {{ $car->seat_number }}</p>
                <a href="/cars/{{ $car->id }}" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
