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
Route::get('/', function () {
    return view('home');
});
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
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password reset routes (admin only)
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Admin redirect route
Route::redirect('/admin', '/admin/dashboard');

// Admin dashboard accessible to all admin roles
Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin,content,saler'])
    ->name('admin.dashboard');

// Admin only routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Invoice trash management
    Route::get('invoices/trash', [AdminInvoiceController::class, 'trash'])->name('invoices.trash');
    Route::post('invoices/{id}/restore', [AdminInvoiceController::class, 'restore'])->name('invoices.restore');
    Route::delete('invoices/{id}/force-delete', [AdminInvoiceController::class, 'forceDelete'])->name('invoices.force-delete');

    Route::resource('users', AdminUserController::class);
    Route::resource('cars', CarController::class);
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
});

// Admin and Saler routes
Route::middleware(['auth', 'role:admin,saler'])->prefix('admin')->name('admin.')->group(function () {
    // Regular invoice routes
    Route::resource('invoices', AdminInvoiceController::class)->except(['trash', 'restore', 'forceDelete']);
    Route::put('/invoices/{id}/status', [AdminInvoiceController::class, 'updateStatus'])->name('invoices.update-status');
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

// Cars routes accessible to all admin roles
Route::middleware(['auth', 'role:admin,content,saler'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('cars', CarController::class)->except(['destroy']);
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

// Authentication routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
