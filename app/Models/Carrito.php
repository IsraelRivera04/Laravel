<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id'];

    public function usuario() {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
    public function items() {
        return $this->hasMany(CarritoItem::class);
    }

    public function total()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->precio_unitario * $item->cantidad;
        }

        return $total;
    }
}
