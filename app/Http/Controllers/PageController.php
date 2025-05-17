<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarDetail;
use App\Models\Banner;

class PageController extends Controller
{
    public function home() {
        $banners = Banner::where('is_active', true)
                        ->orderBy('position')
                        ->with('car')
                        ->get();
        return view('home', compact('banners'));
    }

    public function about() {
        return view('about');
    }

    public function cars() {
        $cars = Car::all();
        return view('cars', compact('cars'));
    }

    public function carDetail($id) {
        $car = Car::with('engine')->findOrFail($id);
        return view('car_detail', compact('car'));
    }

    public function buyForm($id = null) {
        $carDetails = CarDetail::with(['car', 'color'])->get();
        return view('buy', compact('carDetails'));
    }

    public function contact() {
        return view('contact');
    }
}
