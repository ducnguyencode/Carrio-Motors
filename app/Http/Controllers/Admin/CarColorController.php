<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarColor;

class CarColorController extends Controller
{
    /**
     * Display a listing of the car colors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carColors = CarColor::paginate(10);
        return view('admin.car_colors.index', compact('carColors'));
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
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $carColor = new CarColor();
        $carColor->name = $validated['name'];
        $carColor->hex_code = $validated['hex_code'];
        $carColor->description = $validated['description'] ?? null;

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('car_colors', 'public');
            $carColor->image = $imagePath;
        }

        $carColor->save();

        return redirect()->route('admin.car_colors.index')
            ->with('success', 'Màu xe đã được tạo thành công.');
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
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $carColor->name = $validated['name'];
        $carColor->hex_code = $validated['hex_code'];
        $carColor->description = $validated['description'] ?? null;

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($carColor->image) {
                Storage::disk('public')->delete($carColor->image);
            }

            $imagePath = $request->file('image')->store('car_colors', 'public');
            $carColor->image = $imagePath;
        }

        $carColor->save();

        return redirect()->route('admin.car_colors.index')
            ->with('success', 'Màu xe đã được cập nhật thành công.');
    }

    /**
     * Remove the specified car color from storage.
     *
     * @param  \App\Models\CarColor  $carColor
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarColor $carColor)
    {
        // Kiểm tra xem có chi tiết xe nào sử dụng màu này không trước khi xóa
        if ($carColor->carDetails()->count() > 0) {
            return redirect()->route('admin.car_colors.index')
                ->with('error', 'Không thể xóa màu xe này vì đã có xe liên kết.');
        }

        // Xóa ảnh nếu có
        if ($carColor->image) {
            Storage::disk('public')->delete($carColor->image);
        }

        $carColor->delete();

        return redirect()->route('admin.car_colors.index')
            ->with('success', 'Màu xe đã được xóa thành công.');
    }
}
