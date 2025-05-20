<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\MakeController;
use App\Http\Controllers\Admin\ModelController;
use App\Http\Controllers\Admin\EngineController;
use App\Http\Controllers\Admin\CarColorController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CarDetailController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Car;
use App\Http\Controllers\CarDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ActivityLogController;

// Public routes
Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/about', [PageController::class, 'about']);
Route::get('/cars', [PageController::class, 'cars'])->name('cars');
Route::get('/cars/{id}', [PageController::class, 'carDetail']);
Route::get('/buy/{id?}', [PageController::class, 'buyForm']);
Route::post('/buy/submit', [BuyController::class, 'submit']);
Route::get('/contact', [PageController::class, 'contact']);

// Registration routes (public)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Admin login routes only (no public registration)
Route::get('/admin', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password reset routes (admin only)
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Admin dashboard accessible to all admin roles
Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin,content,saler'])
    ->name('admin.dashboard');

// Admin only routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', AdminUserController::class);
    Route::resource('invoices', AdminInvoiceController::class);
    // Admin-only destroy actions
    Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
    Route::delete('/car_colors/{car_color}', [CarColorController::class, 'destroy'])->name('car_colors.destroy');
    Route::delete('/car_details/{car_detail}', [CarDetailController::class, 'destroy'])->name('car_details.destroy');
});

// Admin and Content accessible routes (content management)
Route::middleware(['auth', 'role:admin,content,saler'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('makes', MakeController::class);
    Route::resource('models', ModelController::class);
    Route::resource('engines', EngineController::class);
    Route::resource('car_colors', CarColorController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('car_details', CarDetailController::class)->except(['destroy']);
});

// Saler & Admin accessible routes
Route::middleware(['auth', 'role:admin,saler'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('invoices', AdminInvoiceController::class);
    Route::put('/invoices/{id}/status', [AdminInvoiceController::class, 'updateStatus'])->name('invoices.update-status');
});

// Cars routes accessible to all admin roles
Route::middleware(['auth', 'role:admin,content,saler'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('cars', CarController::class)->except(['destroy']);
    Route::get('get-models-by-make', [CarController::class, 'getModelsByMake'])->name('get-models-by-make');
});

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard')->with('success', 'Your email has been successfully verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// User dashboard (for normal users)
Route::get('/dashboard', [UserDashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Activity Logs (Admin only)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
});

// Search Bar
Route::get('/search/cars', [PageController::class, 'search'])->name('cars.search');

// Featured Car
Route::get('/featured-cars', [PageController::class, 'featuredCars'])->name('featured.cars');

// Detail
Route::get('/cars/{id}', [PageController::class, 'carDetail'])->name('car.detail');
