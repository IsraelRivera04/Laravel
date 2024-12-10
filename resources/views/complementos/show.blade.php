@extends('plantilla')

@section('contenido')

<div class="container mt-4 text-center">
    <h1>{{ $complemento->nombre }}</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex align-items-center">
            <table class="table table-bordered">
                <tr>
                    <th>Nombre</th>
                    <td>{{ $complemento->nombre }}</td>
                </tr>
                <tr>
                    <th>Descripción</th>
                    <td>{{ $complemento->descripcion ?? 'No disponible' }}</td>
                </tr>
                <tr>
                    <th>Precio</th>
                    <td>{{ $complemento->precio }} €</td>
                </tr>
                <tr>
                    <th>Stock</th>
                    <td>{{ $complemento->stock ?? 'No disponible' }}</td>
                </tr>
            </table>
        </div>
        
        <div class="col-md-8">
            @if($complemento->imagen)
                <img src="{{ $complemento->imagen }}" alt="Imagen del complemento" class="img-fluid rounded shadow-sm" style="width: 556px">
            @else
                <p>No hay imagen disponible para este complemento.</p>
            @endif
        </div>
    </div>
    <form action="{{ route('carrito.agregar') }}" method="POST">
        @csrf
        <input type="hidden" name="producto_id" value="{{ $complemento->id }}">
        <input type="hidden" name="tipo" value="complemento">
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" value="1" min="1" required>
        <button type="submit" class="btn btn-success">Añadir al Carrito</button>
    </form>
    
    <div class="mt-4">
        <a href="{{ route('complementos.index') }}" class="btn btn-secondary">Volver al listado</a>
    </div>
</div>

@endsection
