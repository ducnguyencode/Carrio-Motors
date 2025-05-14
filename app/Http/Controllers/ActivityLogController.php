<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::query()->orderBy('created_at', 'desc');

        // Filter by user
        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by action
        if ($request->has('action') && !empty($request->action)) {
            $query->where('action', $request->action);
        }

        // Filter by module
        if ($request->has('module') && !empty($request->module)) {
            $query->where('module', $request->module);
        }

        // Date range filter
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(20);

        // Get unique values for filters
        $users = ActivityLog::select('user_id', 'user_name')
            ->whereNotNull('user_id')
            ->distinct()
            ->get()
            ->pluck('user_name', 'user_id');

        $actions = ActivityLog::select('action')
            ->distinct()
            ->pluck('action');

        $modules = ActivityLog::select('module')
            ->distinct()
            ->pluck('module');

        return view('admin.activity-logs.index', compact('logs', 'users', 'actions', 'modules'));
    }

    /**
     * Display the specified activity log.
     */
    public function show(ActivityLog $activityLog)
    {
        return view('admin.activity-logs.show', compact('activityLog'));
    }
}
