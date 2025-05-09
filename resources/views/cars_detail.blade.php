@extends('layouts.app')
@section('content')
<h2>{{ $car->name }}</h2>
<p><strong>Brand:</strong> {{ $car->brand }}</p>
<p><strong>Engine:</strong> {{ $car->engine->name }}</p>
<p><strong>Seats:</strong> {{ $car->seat_number }}</p>
<p><strong>Transmission:</strong> {{ $car->transmission }}</p>
<p><strong>Description:</strong> {{ $car->description }}</p>
<a href="/buy/{{ $car->id }}" class="btn btn-success">Buy Now</a>
@endsection
