<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarColor;
use Illuminate\Support\Facades\Storage;

class CarColorController extends Controller
{
    /**
     * Display a listing of the car colors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carcolors = CarColor::paginate(10);
        return view('admin.car_colors.index', compact('carcolors'));
    }

    /**
     * Show the form for creating a new car color.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.car_colors.create');
    }

    /**
     * Store a newly created car color in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'hex_code' => 'required|string|max:7|regex:/^#[0-9A-F]{6}$/i',
        ]);

        $carColor = new CarColor();
        $carColor->name = $validated['name'];
        $carColor->hex_code = strtoupper($validated['hex_code']);
        $carColor->is_active = $request->has('is_active');
        $carColor->save();

        return redirect()->route('admin.car_colors.index')
            ->with('success', 'Car color created successfully.');
    }

    /**
     * Display the specified car color.
     *
     * @param  \App\Models\CarColor  $carColor
     * @return \Illuminate\Http\Response
     */
    public function show(CarColor $carColor)
    {
        return view('admin.car_colors.show', compact('carColor'));
    }

    /**
     * Show the form for editing the specified car color.
     *
     * @param  \App\Models\CarColor  $carColor
     * @return \Illuminate\Http\Response
     */
    public function edit(CarColor $carColor)
    {
        return view('admin.car_colors.edit', compact('carColor'));
    }

    /**
     * Update the specified car color in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarColor  $carColor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarColor $carColor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'hex_code' => 'required|string|max:7|regex:/^#[0-9A-F]{6}$/i',
        ]);

        $carColor->name = $validated['name'];
        $carColor->hex_code = strtoupper($validated['hex_code']);
        $carColor->is_active = $request->has('is_active');
        $carColor->save();

        return redirect()->route('admin.car_colors.index')
            ->with('success', 'Car color updated successfully.');
    }

    /**
     * Remove the specified car color from storage.
     *
     * @param  \App\Models\CarColor  $carColor
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarColor $carColor)
    {
        // Check if there are any car details using this color before deleting
        if ($carColor->carDetails()->count() > 0) {
            return redirect()->route('admin.car_colors.index')
                ->with('error', 'Cannot delete this color as it is being used by one or more cars.');
        }

        $carColor->delete();

        return redirect()->route('admin.car_colors.index')
            ->with('success', 'Car color deleted successfully.');
    }
}
