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
            'model_id' => 'required|exists:model,id',
            'engine_id' => 'required|exists:engine,id',
            'car_id' => 'required|exists:car,id',
            'color_id' => 'required|exists:car_color,id',
            'transmission_id' => 'required|exists:transmission,id',
            'mileage' => 'required|exists:mileage,id'
        ]);
        $carDetail = CarDetail::create($validatedData);
        return response()->json($carDetail);
    }
    public function show(CarDetail $carDetail) {
        return response()->json($carDetail);
    }

    public function update(Request $request, CarDetail $carDetail) {

    $validatedData = $request->validate([
        'model_id' => 'required|exists:model,id',
        'engine_id' => 'required|exists:engine,id',
        'car_id' => 'required|exists:car,id',
        'color_id' => 'required|exists:car_color,id',
        'transmission_id' => 'required|exists:transmission,id',
        'mileage' => 'required|exists:mileage,id'.$carDetail->id.',id',
    ]);

    $carDetail = $carDetail->update($validatedData);
    return response()->json($carDetail);
    }

    public function destroy(CarDetail $carDetail) {
        $carDetail->delete();
        return response()->json(null,204);
    }
}