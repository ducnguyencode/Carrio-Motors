<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Banner;
use App\Models\Car;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // Get counts for dashboard
        $userCount = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $customerCount = User::where('role', 'customer')->count();

        // Get latest users
        $latestUsers = User::latest()->take(5)->get();

        // Get recent invoices
        $recentInvoices = Invoice::with('user')->latest()->take(5)->get();

        // Get car count
        $carCount = Car::count();

        // Get banner count
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
}
