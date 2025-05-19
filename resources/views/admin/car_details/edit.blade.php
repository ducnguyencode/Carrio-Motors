@extends('admin.layouts.app')

@section('title', 'Edit Car Detail')

@section('page-heading', 'Edit Car Detail')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="{{ route('car_details.update', $carDetail) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Car -->
            <div>
                <label for="car_id">Car</label>
                <select name="car_id" id="car_id">
                    @foreach ($cars as $car)
                        <option value="{{ $car->id }}" {{ $carDetail->car_id == $car->id ? 'selected' : '' }}>{{ $car->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Color -->
            <div>
                <label for="color_id">Color</label>
                <select name="color_id" id="color_id">
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}" {{ $carDetail->color_id == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Quantity -->
            <div>
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="{{ $carDetail->quantity }}">
            </div>
        </div>

        <div class="mt-8">
            <button type="submit">Update Car Detail</button>
        </div>
    </form>
</div>
@endsection