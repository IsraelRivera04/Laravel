<?php

namespace App\Policies;

use App\Models\usuario;
use App\Models\Juego;
use Illuminate\Auth\Access\HandlesAuthorization;

class JuegoPolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario puede crear juegos.
     *
     * @param  \App\Models\usuario  $usuario
     * @return bool
     */
    public function create(Usuario $usuario)
    {
        return $usuario->rol === 'admin';
    }

    /**
     * Determina si el usuario puede editar un juego.
     *
     * @param  \App\Models\usuario  $usuario
     * @param  \App\Models\Juego  $juego
     * @return bool
     */
    public function update(usuario $usuario, Juego $juego)
    {
        return $usuario->rol === 'admin' || $usuario->id === $juego->usuario_id;
    }

    /**
     * Determina si el usuario puede eliminar un juego.
     *
     * @param  \App\Models\usuario  $usuario
     * @param  \App\Models\Juego  $juego
     * @return bool
     */
    public function delete(usuario $usuario, Juego $juego)
    {
        return $usuario->rol === 'admin' || $usuario->id === $juego->usuario_id;
    }

    /**
     * Determina si el usuario puede ver un juego.
     *
     * @param  \App\Models\usuario  $usuario
     * @param  \App\Models\Juego  $juego
     * @return bool
     */
    public function view(usuario $usuario, Juego $juego)
    {
        return true;  // Todos los usuarios pueden ver los juegos
    }
}
