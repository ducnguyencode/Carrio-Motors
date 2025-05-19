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
        $carDetails = CarDetail::with(['car', 'carColor'])->paginate(10);
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
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'car_color_id' => 'required|exists:car_colors,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'is_available' => 'sometimes|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $carDetail = new CarDetail();
        $carDetail->car_id = $validated['car_id'];
        $carDetail->car_color_id = $validated['car_color_id'];
        $carDetail->quantity = $validated['quantity'];
        $carDetail->price = $validated['price'];
        $carDetail->is_available = $request->has('is_available');

        // Xử lý upload các ảnh nếu có
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('car_details', 'public');
                $images[] = $path;
            }
            $carDetail->images = json_encode($images);
        }

        $carDetail->save();

        return redirect()->route('admin.car_details.index')
            ->with('success', 'Chi tiết xe đã được tạo thành công.');
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
            'is_available' => 'sometimes|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_images' => 'nullable|array',
        ]);

        $carDetail->car_id = $validated['car_id'];
        $carDetail->car_color_id = $validated['car_color_id'];
        $carDetail->quantity = $validated['quantity'];
        $carDetail->price = $validated['price'];
        $carDetail->is_available = $request->has('is_available');

        // Xử lý các ảnh cần xóa
        if ($request->has('remove_images') && is_array($request->remove_images)) {
            $images = json_decode($carDetail->images ?? '[]', true);
            $newImages = [];

            foreach ($images as $index => $imagePath) {
                if (!in_array($index, $request->remove_images)) {
                    $newImages[] = $imagePath;
                } else {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            $carDetail->images = json_encode($newImages);
        }

        // Xử lý thêm ảnh mới
        if ($request->hasFile('images')) {
            $images = json_decode($carDetail->images ?? '[]', true);

            foreach ($request->file('images') as $image) {
                $path = $image->store('car_details', 'public');
                $images[] = $path;
            }

            $carDetail->images = json_encode($images);
        }

        $carDetail->save();

        return redirect()->route('admin.car_details.index')
            ->with('success', 'Chi tiết xe đã được cập nhật thành công.');
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
                ->with('error', 'Không thể xóa chi tiết xe này vì đã có đơn hàng liên kết.');
        }

        // Xóa các ảnh nếu có
        if ($carDetail->images) {
            $images = json_decode($carDetail->images, true);
            foreach ($images as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $carDetail->delete();

        return redirect()->route('admin.car_details.index')
            ->with('success', 'Chi tiết xe đã được xóa thành công.');
    }
}
