<?php
namespace App\Http\Controllers;

use App\Models\CarColor;
use Illuminate\Http\Request;

class CarColorController extends Controller
{
    public function index()
    {
        $colors = CarColor::paginate(10);
        return view('car_colors.index', compact('colors'));
    }

    public function create()
    {
        return view('car_colors.create');
    }

    public function store(Request $request)
    {
        CarColor::create($request->validate([
            'name' => 'required',
            'hex_code' => 'required',
            'is_active' => 'boolean'
        ]));

        return redirect()->route('car_colors.index');
    }

    public function edit(CarColor $carColor)
    {
        return view('car_colors.edit', compact('carColor'));
    }

    public function update(Request $request, CarColor $carColor)
    {
        $carColor->update($request->validate([
            'name' => 'required',
            'hex_code' => 'required',
            'is_active' => 'boolean'
        ]));

        return redirect()->route('car_colors.index');
    }

    public function destroy(CarColor $carColor)
    {
        $carColor->delete();
        return redirect()->route('car_colors.index');
    }
}