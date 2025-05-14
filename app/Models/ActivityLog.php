<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'user_role',
        'user_name',
        'action',
        'module',
        'reference_id',
        'details',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the user that performed the activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set the details attribute as JSON.
     *
     * @param mixed $value
     * @return void
     */
    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Get the details attribute as an array.
     *
     * @param string|null $value
     * @return array|null
     */
    public function getDetailsAttribute($value)
    {
        return $value ? json_decode($value, true) : null;
    }
}
