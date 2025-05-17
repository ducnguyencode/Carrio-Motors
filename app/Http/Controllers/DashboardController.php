<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Banner;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        // Admin dashboard
        if ($role === 'admin') {
            $userCount = User::count();
            $adminCount = User::where('role', 'admin')->count();
            $customerCount = User::where('role', 'user')->count();
            $latestUsers = User::latest()->take(5)->get();
            $recentInvoices = Invoice::with('user')->latest()->take(5)->get();
            $carCount = Car::count();
            $bannerCount = Banner::count();

            return view('admin.dashboard', compact(
                'userCount',
                'adminCount',
                'customerCount',
                'latestUsers',
                'recentInvoices',
                'carCount',
                'bannerCount'
            ));
        }

        // Content manager dashboard
        if ($role === 'content') {
            $carCount = Car::count();
            $bannerCount = Banner::count();
            return view('user.dashboard', compact('user', 'carCount', 'bannerCount'));
        }

        // Saler dashboard
        if ($role === 'saler') {
            $invoiceCount = Invoice::where('saler_id', $user->id)->count();
            $recentInvoices = Invoice::where('saler_id', $user->id)
                ->with('user')
                ->latest()
                ->take(5)
                ->get();
            return view('user.dashboard', compact('user', 'invoiceCount', 'recentInvoices'));
        }

        // Regular user dashboard
        return view('user.dashboard', compact('user'));
    }
}
