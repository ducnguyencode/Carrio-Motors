<?php

namespace App\Http\Controllers;

use App\Models\CarDetail;
use Illuminate\Http\Request;

class CarDetailController extends Controller
{
    public function index() {
        return response()->json(CarDetail::all());
    }
    public function store(Request $request) {
        $validatedData = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'color_id' => 'required|exists:car_colors,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'is_available' => 'sometimes|boolean'
        ]);
        $carDetail = CarDetail::create($validatedData);
        return response()->json($carDetail);
    }
    public function show(CarDetail $carDetail) {
        return response()->json($carDetail);
    }

    public function update(Request $request, CarDetail $carDetail) {

    $validatedData = $request->validate([
        'car_id' => 'required|exists:cars,id',
        'color_id' => 'required|exists:car_colors,id',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'is_available' => 'sometimes|boolean'
    ]);

    $carDetail = $carDetail->update($validatedData);
    return response()->json($carDetail);
    }

    public function destroy(CarDetail $carDetail) {
        $carDetail->delete();
        return response()->json(null,204);
    }
}
