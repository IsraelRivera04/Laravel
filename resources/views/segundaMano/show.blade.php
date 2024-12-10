@extends('plantilla')

@section('contenido')

<div class="container text-center">
    <h1 class="mb-4">{{ $segundaManoJuego->nombre }}</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Nombre</th>
                            <td>{{ $segundaManoJuego->nombre }}</td>
                        </tr>
                        <p><strong>Publicado por:</strong> {{ $segundaManoJuego->usuario->username ?? 'Usuario desconocido' }}</p>
                        <tr>
                            <th>Descripción</th>
                            <td>{{ $segundaManoJuego->descripcion ?? 'No disponible' }}</td>
                        </tr>
                        <tr>
                            <th>Edición</th>
                            <td>{{ $segundaManoJuego->edicion }}</td>
                        </tr>
                        <tr>
                            <th>Número de Jugadores Mínimo</th>
                            <td>{{ $segundaManoJuego->num_jugadores_min }}</td>
                        </tr>
                        <tr>
                            <th>Número de Jugadores Máximo</th>
                            <td>{{ $segundaManoJuego->num_jugadores_max }}</td>
                        </tr>
                        <tr>
                            <th>Edad Recomendada</th>
                            <td>{{ $segundaManoJuego->edad_recomendada }}</td>
                        </tr>
                        <tr>
                            <th>Duración Aproximada</th>
                            <td>{{ $segundaManoJuego->duracion_aprox }}</td>
                        </tr>
                        <tr>
                            <th>Editor</th>
                            <td>{{ $segundaManoJuego->editor }}</td>
                        </tr>
                        <tr>
                            <th>Diseñador</th>
                            <td>{{ $segundaManoJuego->disenador }}</td>
                        </tr>
                        <tr>
                            <th>Año Publicación</th>
                            <td>{{ $segundaManoJuego->ano_publicacion }}</td>
                        </tr>
                        <tr>
                            <th>Dureza</th>
                            <td>{{ $segundaManoJuego->dureza }}</td>
                        </tr>
                        <tr>
                            <th>Precio</th>
                            <td><strong>{{ $segundaManoJuego->precio }} €</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if($segundaManoJuego->imagen)
                        <img src="{{ $segundaManoJuego->imagen }}" alt="Imagen del segundaManoJuego" class="img-fluid rounded shadow-sm">
                    @else
                        <p class="alert alert-warning">No hay imagen disponible para este producto.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h4>Añadir al Carrito</h4>
        <form action="{{ route('carrito.agregar') }}" method="POST">
            @csrf
            <input type="hidden" name="producto_id" value="{{ $segundaManoJuego->id }}">
            <input type="hidden" name="tipo" value="segunda_mano">

            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" value="1" min="1" max="1" class="form-control w-25 mx-auto" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Añadir al Carrito</button>
        </form>
    </div>

    <h3 class="mt-5"><strong>Complementos relacionados:</strong></h3>
    @if($complementos->isEmpty())
        <p class="text-muted">Este producto no tiene complementos disponibles.</p>
    @else
        <div class="row mt-4">
            @foreach($complementos as $complemento)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <img src="{{ $complemento->imagen }}" alt="Imagen del complemento" class="card-img-top img-complemento">
                        <div class="card-body">
                            <h5 class="card-title">{{ $complemento->nombre }}</h5>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($complemento->descripcion, 100) }}</p>
                            <p class="text-success"><strong>Precio: {{ number_format($complemento->precio, 2) }}€</strong></p>
                            <a href="{{ route('complemento.detalle', $complemento->id) }}" class="btn btn-primary">Ver detalle</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-2 mb-4">
        <a href="{{ route('segundaMano.index') }}" class="btn btn-secondary">Volver al listado</a>
    </div>
</div>

@endsection