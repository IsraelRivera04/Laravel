@extends('plantilla')

@section('contenido')
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h1 class="display-4 text-primary">Listado de Juegos</h1>
                <p class="lead text-muted">Explora todos nuestros juegos de mesa disponibles.</p>
            </div>
        </div>

        <div class="mb-3 text-center">
            <form method="POST" action="{{ route('juegos.asignarOfertas') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-success">Asignar Ofertas Aleatorias</button>
            </form>
        </div>

        <div class="mb-3 text-center">
            <form method="GET" action="{{ route('juegos.index') }}">
                <button type="submit" name="oferta" value="1" class="btn btn-sm btn-info">Juegos en Oferta</button>
                <button type="submit" name="oferta" value="0" class="btn btn-sm btn-secondary">Todos los Juegos</button>
            </form>
        </div>

        <table class="table table-hover table-bordered shadow-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Número de Jugadores</th>
                    <th>Diseñador</th>
                    <th>Duración</th>
                    <th>Precio</th>
                    <th>Descuento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($juegos as $juego)
                    <tr>
                        <td>{{ $juego->nombre }}</td>
                        <td>{{ $juego->num_jugadores_min }} - {{ $juego->num_jugadores_max }}</td>
                        <td>{{ $juego->disenador }}</td>
                        <td>{{ $juego->duracion_aprox }} min</td>
                        <td>
                            @if($juego->oferta)
                                <span class="text-danger">{{ number_format($juego->precio_oferta, 2) }} €</span>
                                <small class="text-muted"><del>{{ number_format($juego->precio, 2) }} €</del></small>
                            @else
                                {{ number_format($juego->precio, 2) }} €
                            @endif
                        </td>
                        <td>
                            @if($juego->oferta)
                                <span class="text-success">{{ round((1 - ($juego->precio_oferta / $juego->precio)) * 100) }}% Descuento</span>
                            @else
                                No hay oferta
                            @endif
                        <td>
                            <a href="{{ route('juegos.show', $juego->id) }}" class="btn btn-sm btn-info">Ver</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('juegos.edit', $juego->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('juegos.destroy', $juego->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres borrar este juego?')">Borrar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-4">
            {{ $juegos->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
