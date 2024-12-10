<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = ['juego_id', 'usuario_id', 'comentario', 'valoracion'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function juego()
    {
        return $this->belongsTo(Juego::class);
    }
}
