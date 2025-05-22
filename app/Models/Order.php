<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'car_id',
        'car_detail_id',
        'quantity',
        'total_price',
        'payment_method',
        'additional_info',
        'status'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function carDetail()
    {
        return $this->belongsTo(CarDetail::class, 'car_detail_id');
    }
}
