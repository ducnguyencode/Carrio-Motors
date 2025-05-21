<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Make;
use App\Models\Engine;
use Illuminate\Support\Facades\Storage;
use App\Models\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\CarModel;
use App\Models\InvoiceDetail;

class CarController extends Controller
{
    /**
     * Display a listing of the cars.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Car::with(['model.make', 'engine']);

        // Apply search if provided
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhereHas('model', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhereHas('make', function($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%");
                        });
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all' && !empty($request->status)) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('isActive', $status);
        }

        $cars = $query->paginate(10);

        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new car.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $makes = Make::where('isActive', true)->get();
        $models = [];
        $engines = Engine::all();
        return view('admin.cars.create', compact('makes', 'models', 'engines'));
    }

    /**
     * Get models by make id for AJAX request
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getModelsByMake(Request $request)
    {
        $make_id = $request->input('make_id');
        $models = CarModel::where('make_id', $make_id)
                    ->where('isActive', true)
                    ->get();
        return response()->json($models);
    }

    /**
     * Store a newly created car in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'make_id' => 'required|exists:makes,id',
            'model_id' => 'required|exists:models,id',
            'engine_id' => 'required|exists:engines,id',
            'seat_number' => 'required|integer|in:2,4,5,7,9',
            'transmission' => 'required|in:manual,automatic',
            'description' => 'nullable|string',
            'date_manufactured' => 'required|date',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create new car
        $car = new Car();
        $car->name = $validated['name'];
        $car->model_id = $validated['model_id'];
        $car->engine_id = $validated['engine_id'];
        $car->seat_number = $validated['seat_number'];
        $car->transmission = $validated['transmission'];
        $car->description = $validated['description'] ?? null;
        $car->isActive = $request->has('is_active') ? true : false;
        $car->date_manufactured = $validated['date_manufactured'];

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('cars', 'public');
            $car->main_image = $mainImagePath;
        }

        $car->save();

        // Handle additional images upload
        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            foreach ($request->file('additional_images') as $image) {
                $imagePath = $image->store('cars', 'public');
                $additionalImages[] = $imagePath;
            }
            $car->additional_images = json_encode($additionalImages);
            $car->save();
        }

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car created successfully');
    }

    /**
     * Display the specified car.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        return view('admin.cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified car.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        $makes = Make::all();
        $car->load('model.make');
        $models = CarModel::where('make_id', $car->model->make_id)->get();
        $engines = Engine::all();
        return view('admin.cars.edit', compact('car', 'makes', 'models', 'engines'));
    }

    /**
     * Update the specified car in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'make_id' => 'required|exists:makes,id',
            'model_id' => 'required|exists:models,id',
            'engine_id' => 'required|exists:engines,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'seat_number' => 'required|integer|in:2,4,5,7,9',
            'transmission' => 'required|in:manual,automatic',
            'date_manufactured' => 'required|date',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_additional_images' => 'nullable|array',
        ]);

        $car->model_id = $validated['model_id'];
        $car->engine_id = $validated['engine_id'];
        $car->name = $validated['name'];
        $car->description = $validated['description'] ?? null;
        $car->seat_number = $validated['seat_number'];
        $car->transmission = $validated['transmission'];
        $car->isActive = $request->has('is_active') ? true : false;
        $car->date_manufactured = $validated['date_manufactured'];

        // Xử lý upload ảnh chính nếu có
        if ($request->hasFile('main_image')) {
            // Xóa ảnh cũ
            if ($car->main_image) {
                Storage::disk('public')->delete($car->main_image);
            }

            $mainImagePath = $request->file('main_image')->store('cars', 'public');
            $car->main_image = $mainImagePath;
        }

        // Xử lý các ảnh bổ sung cần xóa
        if ($request->has('remove_additional_images') && is_array($request->remove_additional_images)) {
            $additionalImages = json_decode($car->additional_images ?? '[]', true);
            $newAdditionalImages = [];

            foreach ($additionalImages as $index => $imagePath) {
                if (!in_array($index, $request->remove_additional_images)) {
                    $newAdditionalImages[] = $imagePath;
                } else {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            $car->additional_images = json_encode($newAdditionalImages);
        }

        // Xử lý thêm ảnh bổ sung mới
        if ($request->hasFile('additional_images')) {
            $additionalImages = json_decode($car->additional_images ?? '[]', true);

            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('cars', 'public');
                $additionalImages[] = $path;
            }

            $car->additional_images = json_encode($additionalImages);
        }

        $car->save();

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car updated successfully.');
    }

    /**
     * Remove the specified car from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        // Kiểm tra xem có đơn hàng nào liên quan không
        $hasInvoices = InvoiceDetail::whereHas('carDetail', function($query) use ($car) {
            $query->where('car_id', $car->id);
        })->exists();

        if ($hasInvoices) {
            return redirect()->route('admin.cars.index')
                ->with('error', 'Cannot delete this car because it has associated orders.');
        }

        // Xóa ảnh chính
        if ($car->main_image) {
            Storage::disk('public')->delete($car->main_image);
        }

        // Xóa các ảnh bổ sung
        if ($car->additional_images) {
            $additionalImages = json_decode($car->additional_images, true);
            foreach ($additionalImages as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        // Xóa các chi tiết xe liên quan
        $car->carDetails()->delete();

        $car->delete();

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car deleted successfully.');
    }
}
