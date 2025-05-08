<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BuyController;

Route::get('/about', [PageController::class, 'about']);
Route::get('/cars', [PageController::class, 'cars']);
Route::get('/cars/{id}', [PageController::class, 'carDetail']);
Route::get('/buy/{id?}', [PageController::class, 'buyForm']);
Route::post('/buy/submit', [BuyController::class, 'submit']);
Route::get('/contact', [PageController::class, 'contact']);
Route::get('/', function () {
    return view('home');
});

Route::resource('users', UserController::class)
    ->middleware('auth');

