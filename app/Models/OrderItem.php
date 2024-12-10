<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'producto_id','producto_type', 'cantidad', 'precio_unitario'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function producto()
    {
        return $this->morphTo();
    }
}

