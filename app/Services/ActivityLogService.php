<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Log an activity.
     *
     * @param string $action The action performed (create, update, delete, etc.)
     * @param string $module The module affected (users, cars, etc.)
     * @param string|int|null $referenceId The ID of the affected record
     * @param array|null $details Additional details about the activity
     * @return ActivityLog
     */
    public static function log(string $action, string $module, $referenceId = null, array $details = null)
    {
        $user = Auth::user();

        $log = ActivityLog::create([
            'user_id' => $user ? $user->id : null,
            'user_role' => $user ? $user->role : null,
            'user_name' => $user ? $user->username : null,
            'action' => $action,
            'module' => $module,
            'reference_id' => $referenceId,
            'details' => $details,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);

        return $log;
    }
}
