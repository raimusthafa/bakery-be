<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'user_id',
        'order_date',
        'total_price',
        'status',
        'pickup_date',
        'delivery_method',
        'notes',
    ];

    // Relasi: Order dimiliki oleh User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Order punya banyak OrderItem
    public function orderItems()
    {
        return $this->hasMany(Order_items::class);
    }

    // Relasi: Order punya satu Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
