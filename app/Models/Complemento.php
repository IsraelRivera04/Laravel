<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complemento extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'precio', 'imagen', 'stock'];

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

}
