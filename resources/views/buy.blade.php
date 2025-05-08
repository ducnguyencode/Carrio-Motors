@extends('layouts.app')
@section('content')
<h2>Buy a Car</h2>
<form method="POST" action="/buy/submit">
    @csrf
    <div class="mb-3">
        <label>Your Name</label>
        <input type="text" name="customer_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="customer_email" class="form-control">
    </div>
    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="customer_phone" class="form-control">
    </div>
    <div class="mb-3">
        <label>Car</label>
        <select name="car_detail_id" class="form-control">
            @foreach ($carDetails as $cd)
            <option value="{{ $cd->id }}">{{ $cd->car->name }} - {{ $cd->color->color_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Quantity</label>
        <input type="number" name="quantity" class="form-control" value="1" min="1">
    </div>
    <div class="mb-3">
        <label>Payment Method</label>
        <select name="payment_method" class="form-control">
            <option value="Cash">Cash</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="Installment">Installment</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
