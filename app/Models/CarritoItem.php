<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoItem extends Model
{
    use HasFactory;

    protected $fillable = ['carrito_id', 'producto_id', 'producto_type', 'cantidad', 'precio_unitario', 'usuario_id'];

    public function carrito()
    {
        return $this->belongsTo(Carrito::class);
    }
    
    public function producto()
    {
        return $this->morphTo();
    }
}