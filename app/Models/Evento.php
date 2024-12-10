<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha',
        'ubicacion',
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

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function participantes()
    {
    return $this->belongsToMany(Usuario::class, 'evento_usuario', 'evento_id', 'usuario_id');
    }
}
