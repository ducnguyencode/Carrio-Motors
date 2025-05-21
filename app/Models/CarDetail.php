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
        'price',
        'is_available',
        'main_image',
        'additional_images'
    ];

    protected $casts = [
        'additional_images' => 'array',
        'is_available' => 'boolean'
    ];

    public function car() {
        return $this->belongsTo(Car::class);
    }

    public function carColor() {
        return $this->belongsTo(CarColor::class, 'color_id');
    }

    public function invoiceDetails() {
        return $this->hasMany(InvoiceDetail::class);
    }
}
