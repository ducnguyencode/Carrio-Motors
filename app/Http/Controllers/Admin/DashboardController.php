<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total number of users
        $totalUsers = User::count();

        // Total number of cars
        $totalCars = Car::count();

        // New orders today/week
        $newOrdersToday = Invoice::whereDate('created_at', Carbon::today())->count();
        $newOrdersThisWeek = Invoice::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        // This month's revenue
        $revenueThisMonth = Invoice::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('process_status', 'success')
            ->sum('total_price');

        // Monthly revenue (for chart)
        $monthlyRevenue = Invoice::where('process_status', 'success')
            ->whereYear('created_at', Carbon::now()->year)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_price) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->toArray();

        // Recent invoices
        $recentInvoices = Invoice::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Chart data
        $chartData = [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            'data' => array_fill(0, 12, 0),
        ];

        foreach ($monthlyRevenue as $revenue) {
            $chartData['data'][$revenue['month'] - 1] = $revenue['total'];
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCars',
            'newOrdersToday',
            'newOrdersThisWeek',
            'revenueThisMonth',
            'chartData',
            'recentInvoices'
        ));
    }
}
