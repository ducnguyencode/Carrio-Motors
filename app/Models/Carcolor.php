<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarColor extends Model
{
    use HasFactory;

    protected $table = 'car_colors';

    protected $fillable = [
        'name',
        'hex_code'
    ];

    public function car_details()
    {
        return $this->belongsTo(CarDetail::class, 'color_id');
    }
}
