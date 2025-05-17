<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
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
                ->sum('total_price') ?? 0;

            // Monthly revenue (for chart)
            $monthlyRevenue = Invoice::whereYear('created_at', Carbon::now()->year)
                ->select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COALESCE(SUM(total_price), 0) as total')
                )
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Log raw monthly revenue data
            \Log::info('Raw Monthly Revenue:', $monthlyRevenue->toArray());

            // Initialize data array with zeros for all months
            $chartData = [
                'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                'data' => array_fill(0, 12, 0),
            ];

            // Fill in actual data and convert to float
            foreach ($monthlyRevenue as $revenue) {
                $chartData['data'][$revenue->month - 1] = round((float) $revenue->total, 2);
            }

            // Log final chart data
            \Log::info('Final Chart Data:', $chartData);

            // Check if we have any completed orders
            $completedOrdersCount = Invoice::where('status', 'completed')->count();
            \Log::info('Total completed orders: ' . $completedOrdersCount);

            // Recent invoices with pagination
            $recentInvoices = Invoice::with('user')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('admin.dashboard', compact(
                'totalUsers',
                'totalCars',
                'newOrdersToday',
                'newOrdersThisWeek',
                'revenueThisMonth',
                'chartData',
                'recentInvoices'
            ));

        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            \Log::error('Error trace: ' . $e->getTraceAsString());

            return view('admin.dashboard', [
                'totalUsers' => 0,
                'totalCars' => 0,
                'newOrdersToday' => 0,
                'newOrdersThisWeek' => 0,
                'revenueThisMonth' => 0,
                'chartData' => [
                    'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    'data' => array_fill(0, 12, 0),
                ],
                'recentInvoices' => collect([]),
                'error' => 'There was an error loading the dashboard data. Please try again later.'
            ]);
        }
    }
}
