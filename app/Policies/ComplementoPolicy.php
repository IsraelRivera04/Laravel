<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Complemento;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComplementoPolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario puede crear complementos.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return bool
     */
    public function create(Usuario $usuario)
    {
        return $usuario->rol === 'admin';
    }

    /**
     * Determina si el usuario puede editar un complemento.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \App\Models\Complemento  $complemento
     * @return bool
     */
    public function update(Usuario $usuario, Complemento $complemento)
    {
        return $usuario->rol === 'admin' || $usuario->id === $complemento->usuario_id;
    }

    /**
     * Determina si el usuario puede eliminar un complemento.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \App\Models\Complemento  $complemento
     * @return bool
     */
    public function delete(Usuario $usuario, Complemento $complemento)
    {
        return $usuario->rol === 'admin' || $usuario->id === $complemento->usuario_id;
    }

    /**
     * Determina si el usuario puede ver un complemento.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \App\Models\Complemento  $complemento
     * @return bool
     */
    public function view(Usuario $usuario, Complemento $complemento)
    {
        return true;  // Todos los usuarios pueden ver los complementos
    }
}
