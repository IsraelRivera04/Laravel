@extends('plantilla')

@section('contenido')

<div class="container text-center">
    <h1 class="mb-4">{{ $juego->nombre }}</h1>

    <div class="row">
        <!-- Columna de detalles del juego -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Nombre</th>
                            <td>{{ $juego->nombre }}</td>
                        </tr>
                        <tr>
                            <th>Descripción</th>
                            <td>{{ $juego->descripcion ?? 'No disponible' }}</td>
                        </tr>
                        <tr>
                            <th>Edición</th>
                            <td>{{ $juego->edicion }}</td>
                        </tr>
                        <tr>
                            <th>Número de Jugadores Mínimo</th>
                            <td>{{ $juego->num_jugadores_min }}</td>
                        </tr>
                        <tr>
                            <th>Número de Jugadores Máximo</th>
                            <td>{{ $juego->num_jugadores_max }}</td>
                        </tr>
                        <tr>
                            <th>Edad Recomendada</th>
                            <td>{{ $juego->edad_recomendada }}</td>
                        </tr>
                        <tr>
                            <th>Duración Aproximada</th>
                            <td>{{ $juego->duracion_aprox }}</td>
                        </tr>
                        <tr>
                            <th>Editor</th>
                            <td>{{ $juego->editor }}</td>
                        </tr>
                        <tr>
                            <th>Diseñador</th>
                            <td>{{ $juego->disenador }}</td>
                        </tr>
                        <tr>
                            <th>Año Publicación</th>
                            <td>{{ $juego->ano_publicacion }}</td>
                        </tr>
                        <tr>
                            <th>Dureza</th>
                            <td>{{ $juego->dureza }}</td>
                        </tr>
                        <tr>
                            <th>Rating</th>
                            <td>{{ number_format($juego->rating, 2) }} / 10</td>
                        </tr>
                        <tr>
                            <th>Precio</th>
                            <td>
                                @if($juego->oferta)
                                    <span class="text-danger">{{ number_format($juego->precio_oferta, 2) }} €</span>
                                    <small class="text-muted"><del>{{ number_format($juego->precio, 2) }} €</del></small>
                                @else
                                    {{ number_format($juego->precio, 2) }} €
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Stock</th>
                            <td>{{ $juego->stock ?? 'No disponible' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if($juego->imagen)
                        <img src="{{ $juego->imagen }}" alt="Imagen del juego" class="img-fluid rounded shadow-sm">
                    @else
                        <p class="alert alert-warning">No hay imagen disponible para este juego.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h4>Añadir al Carrito</h4>
        <form action="{{ route('carrito.agregar') }}" method="POST">
            @csrf
            <input type="hidden" name="producto_id" value="{{ $juego->id }}">
            <input type="hidden" name="tipo" value="juego">

            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" value="1" min="1" max="{{$juego->stock}}" class="form-control w-25 mx-auto" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Añadir al Carrito</button>
        </form>
    </div>
    <h3>Comentarios</h3>
@auth
    <form action="{{ route('comentarios.store', $juego->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <textarea name="comentario" class="form-control" rows="3" placeholder="Escribe tu comentario aquí..." required></textarea>
        </div>
        <div class="mb-3">
            <label for="valoracion">Valoración (1,00 a 10,00):</label>
            <input type="number" name="valoracion" class="form-control" min="1.00" max="10.00" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
@else
    <p>Inicia sesión para dejar un comentario.</p>
@endauth

@if ($juego->comentarios->isNotEmpty())
    <ul class="list-group mt-3">
        @foreach ($juego->comentarios as $comentario)
            <li class="list-group-item">
                <strong>{{ $comentario->usuario->username }}</strong> 
                <span class="text-muted">(Valoración: {{ number_format($comentario->valoracion, 2) }} / 10)</span>
                <p class="mt-2 mb-1">{{ $comentario->comentario }}</p>
                <small class="text-muted">{{ $comentario->created_at->format('d/m/Y H:i') }}</small>
            </li>
        @endforeach
    </ul>
@else
    <p class="mt-3">Aún no hay comentarios para este juego.</p>
@endif

    <div class="mt-2 mb-4">
        <a href="{{ route('juegos.index') }}" class="btn btn-secondary">Volver al listado</a>
    </div>
</div>

@endsection


