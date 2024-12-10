@extends('plantilla')

@section('contenido')
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h1 class="display-4 text-primary">Listado de Complementos</h1>
                <p class="lead text-muted">Descubre todos nuestros complementos disponibles.</p>
            </div>
        </div>

        <table class="table table-hover table-bordered shadow-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($complementos as $complemento)
                    <tr>
                        <td>{{ $complemento->nombre }}</td>
                        <td>{{ $complemento->precio }}€</td>
                        <td>{{ $complemento->stock }}</td>
                        <td>
                            <a href="{{ route('complementos.show', $complemento->id) }}" class="btn btn-sm btn-info">Ver</a>
                            @auth
                                <a href="{{ route('complementos.edit', $complemento->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('complementos.destroy', $complemento->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres borrar este complemento?')">Borrar</button>
                                </form>
                            @endauth
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-4">
            {{ $complementos->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
