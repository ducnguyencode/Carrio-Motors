<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'purchase_date',
        'total_price',
        'payment_method',
        'process',
        'isActive',
    ];

    protected $casts = [
        'purchase_date' => 'datetime',
        'total_price' => 'decimal:2',
        'isActive' => 'boolean',
    ];

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
