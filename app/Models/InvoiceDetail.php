<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'car_detail_id',
        'quantity',
        'price',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function carDetail()
    {
        return $this->belongsTo(CarDetail::class);
    }
}
