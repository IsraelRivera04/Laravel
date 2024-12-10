<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegundaManoJuego extends Model
{
    use HasFactory;
    protected $table = 'segunda_mano';

    protected $fillable = [
        'nombre',
        'descripcion',
        'edicion',
        'num_jugadores_min',
        'num_jugadores_max',
        'edad_recomendada',
        'duracion_aprox',
        'editor',
        'disenador',
        'ano_publicacion',
        'dureza',
        'precio',
        'imagen',
    ];

    public function setImagenAttribute($value)
    {
        if($value && is_file($value)) {
            $this->attributes['imagen'] = base64_encode(file_get_contents($value));
        } else {
        $this->attributes['imagen'] = $value;
        }
    }

    public function getImagenAttribute($value)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, base64_decode($value));
        finfo_close($finfo);
        return "data:$mimeType;base64,$value";
    }
    
    public function carritoItems()
    {
        return $this->morphMany(CarritoItem::class, 'producto');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

}
