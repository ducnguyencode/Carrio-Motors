<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarDetail extends Model
{
    use HasFactory;

    protected $table = 'cars_details';

    protected $fillable = [
        'car_id',
        'color_id',
        'quantity',
        'price'
    ];

    public function car() {
        return $this->belongsTo(Car::class);
    }

    public function carColor() {
        return $this->belongsTo(CarColor::class, 'color_id');
    }
}
