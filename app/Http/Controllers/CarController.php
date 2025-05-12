<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    public function index() {
        return response()->json(Car::all());
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'model_id' => 'required|exists:model,id',
            'engine_id' => 'required|exists:engine,id',
            'color_id' => 'required',
            'transmission_id' => 'required',
            'mileage' => 'required',
        ]);

    $car = Car::create($validatedData);
    return response()->json($car,201);
    }
    public function show(Car $car) {
        return response()->json($car);
    }
    public function update(Request $request, Car $car){
        $validatedData = $request->validate([
            'model_id' => 'required|exists:model,id',
            'engine_id' => 'required|exists:engine,id',
            'color_id' => 'required',
            'transmission_id' => 'required',
            'mileage' => 'required',
        ]);
        $car->update($validatedData);
        return response()->json($car->update($validatedData));
    }
    public function destroy(Car $car) {
        $car->delete();
        return response()->json(null,204);
    }

}