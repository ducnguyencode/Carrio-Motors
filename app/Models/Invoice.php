<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'purchase_date',
        'total_price',
        'payment_method',
        'process_status',
        'user_id',
    ];

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    /**
     * Get the user that owns the invoice.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
