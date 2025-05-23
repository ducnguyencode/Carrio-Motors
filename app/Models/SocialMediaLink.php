<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform_name',
        'url',
        'icon_class',
        'is_active',
        'display_order',
        'show_on_car_detail',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
        'show_on_car_detail' => 'boolean',
    ];

    // Scope to get only active social media links
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope to order by display_order
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }
}
