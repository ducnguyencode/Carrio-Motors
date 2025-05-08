<?php
use App\Http\Controllers\PageController;
use App\Http\Controllers\BuyController;

Route::get('/', [PageController::class, 'home']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/cars', [PageController::class, 'cars']);
Route::get('/cars/{id}', [PageController::class, 'carDetail']);
Route::get('/buy/{id?}', [PageController::class, 'buyForm']);
Route::post('/buy/submit', [BuyController::class, 'submit']);
Route::get('/contact', [PageController::class, 'contact']);
