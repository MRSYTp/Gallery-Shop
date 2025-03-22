<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class , 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class , 'order_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class , 'order_id');
    }
}
