<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'method',
        'status',
        'proof_image',
    ];

    // Relasi: Payment dimiliki oleh Order
    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    // Accessor untuk image
    protected function proofImage(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn ($value) => $value ? url('/storage/payments/' . $value) : null,
        );
    }
}
