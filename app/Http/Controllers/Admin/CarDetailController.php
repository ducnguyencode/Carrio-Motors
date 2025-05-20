<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarDetail;
use App\Models\Car;
use App\Models\Engine;
use App\Models\Models;
use App\Models\Make;
use Illuminate\Support\Facades\Storage;
use App\Models\CarColor;

class CarDetailController extends Controller
{
    /**
     * Display a listing of the car details.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = CarDetail::with(['car', 'carColor']);

        // Handle search
        if (request()->has('search') && !empty(request('search'))) {
            $search = request('search');
            $query->whereHas('car', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })->orWhereHas('carColor', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if (request()->has('status') && !empty(request('status'))) {
            if (request('status') == 'active') {
                $query->where('is_available', true);
            } elseif (request('status') == 'inactive') {
                $query->where('is_available', false);
            }
        }

        $carDetails = $query->paginate(10);

        return view('admin.car_details.index', compact('carDetails'));
    }

    /**
     * Show the form for creating a new car detail.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cars = Car::all();
        $carcolors = CarColor::all();
        return view('admin.car_details.create', compact('cars', 'carcolors'));
    }

    /**
     * Store a newly created car detail in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Log::info('Form data received:', $request->all());

        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'car_color_id' => 'required|exists:car_colors,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'is_available' => 'nullable|boolean',
        ]);

        try {
            $carDetail = new CarDetail();
            $carDetail->car_id = $validated['car_id'];
            $carDetail->color_id = $validated['car_color_id'];
            $carDetail->quantity = $validated['quantity'];
            $carDetail->price = $validated['price'];
            $carDetail->is_available = $request->has('is_available') ? 1 : 0;

            \Log::info('Attempting to save car detail:', [
                'car_id' => $carDetail->car_id,
                'color_id' => $carDetail->color_id,
                'quantity' => $carDetail->quantity,
                'price' => $carDetail->price,
                'is_available' => $carDetail->is_available
            ]);

            $carDetail->save();

            \Log::info('Car detail saved successfully');

            return redirect()->route('admin.car_details.index')
                ->with('success', 'Car detail created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error creating car detail: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create car detail. Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified car detail.
     *
     * @param  \App\Models\CarDetail  $carDetail
     * @return \Illuminate\Http\Response
     */
    public function show(CarDetail $carDetail)
    {
        $carDetail->load(['car', 'carColor']);
        return view('admin.car_details.show', compact('carDetail'));
    }

    /**
     * Show the form for editing the specified car detail.
     *
     * @param  \App\Models\CarDetail  $carDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(CarDetail $carDetail)
    {
        $cars = Car::all();
        $carColors = CarColor::all();
        return view('admin.car_details.edit', compact('carDetail', 'cars', 'carColors'));
    }

    /**
     * Update the specified car detail in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarDetail  $carDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarDetail $carDetail)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'car_color_id' => 'required|exists:car_colors,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $carDetail->car_id = $validated['car_id'];
        $carDetail->color_id = $validated['car_color_id']; // Map from car_color_id to color_id
        $carDetail->quantity = $validated['quantity'];
        $carDetail->price = $validated['price'];
        $carDetail->is_available = $request->has('is_available') ? 1 : 0;

        $carDetail->save();

        return redirect()->route('admin.car_details.index')
            ->with('success', 'Car detail updated successfully.');
    }

    /**
     * Remove the specified car detail from storage.
     *
     * @param  \App\Models\CarDetail  $carDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarDetail $carDetail)
    {
        // Kiểm tra xem có đơn hàng nào liên quan không
        if ($carDetail->invoiceDetails()->count() > 0) {
            return redirect()->route('admin.car_details.index')
                ->with('error', 'Cannot delete this car detail because it has associated orders.');
        }

        $carDetail->delete();

        return redirect()->route('admin.car_details.index')
            ->with('success', 'Car detail deleted successfully.');
    }
}
