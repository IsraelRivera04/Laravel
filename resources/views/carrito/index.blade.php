@extends('plantilla')

@section('titulo', 'Carrito de Compras')

@section('contenido')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($carrito && $carrito->items->isNotEmpty())
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($carrito->items as $item)
                    @php $subtotal = $item->precio_unitario * $item->cantidad; @endphp
                    <tr>
                        <td>{{ $item->producto->nombre }}</td>
                        <td>
                            <form action="{{ route('carrito.actualizar', $item) }}" method="POST">
                                @csrf
                                <input type="number" name="cantidad" value="{{ $item->cantidad }}" min="1" required>
                                <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                            </form>
                        </td>
                        <td>{{ number_format($item->precio_unitario, 2) }} €</td>
                        <td>{{ number_format($subtotal, 2) }} €</td>
                        <td>
                            <form action="{{ route('carrito.eliminar', $item) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @php $total += $subtotal; @endphp
                @endforeach
            </tbody>
        </table>

        <h3>Total a Pagar: {{ number_format($carrito->total(), 2) }} €</h3>

        <form action="{{ route('carrito.vaciar') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Vaciar Carrito</button>
            <a href="{{ route('compra.finalizar') }}" class="btn btn-success">Finalizar compra</a>
        </form>
    @else
        <p>Tu carrito está vacío.</p>
    @endif
@endsection
