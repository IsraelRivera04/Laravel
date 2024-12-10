@extends('plantilla')

@section('titulo', 'Listado de Juegos de Segunda Mano')

@section('contenido')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Número de Jugadores</th>
                <th>Diseñador</th>
                <th>Duración</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($segundaManoJuegos as $segundaManoJuego)
                <tr>
                    <td>{{ $segundaManoJuego->nombre }}</td>
                    <td>{{ $segundaManoJuego->num_jugadores_min }} - {{ $segundaManoJuego->num_jugadores_max }}</td>
                    <td>{{ $segundaManoJuego->disenador }}</td>
                    <td>{{ $segundaManoJuego->duracion_aprox }} min</td>
                    <td>{{ $segundaManoJuego->precio }} €</td>
                    <td>Publicado por: {{ $segundaManoJuego->usuario->username ?? 'Usuario desconocido' }}</td>
                    <td>
                        <a href="{{ route('segundaMano.show', $segundaManoJuego->id) }}" class="btn btn-info">Ver</a>
                        @if(auth()->id() === $segundaManoJuego->usuario_id)
                            <a href="{{ route('segundaMano.edit', $segundaManoJuego->id) }}" class="btn btn-primary">Editar</a>
                            <form action="{{ route('segundaMano.destroy', $segundaManoJuego->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $segundaManoJuegos->links() }}
    </div>
@endsection