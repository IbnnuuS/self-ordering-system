<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'transaction_id', 'method', 'amount',
        'status', 'qr_url', 'midtrans_response', 'paid_at'
    ];

    protected $casts = [
        'midtrans_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
