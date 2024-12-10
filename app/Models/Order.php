<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id', 'direccion', 'telefono', 'metodo_pago', 'estado', 'total'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
