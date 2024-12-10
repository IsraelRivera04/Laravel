@extends('plantilla')

@section('contenido')
<div class="container">
    <h2>Finalizar compra</h2>
    <form action="{{ route('compra.procesar') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="direccion">Dirección de Envío</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion') }}" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}" required>
        </div>

        <div class="form-group">
            <label for="metodo_pago">Método de Pago</label>
            <select class="form-control" id="metodo_pago" name="metodo_pago" required>
                <option value="tarjeta" {{ old('metodo_pago') == 'tarjeta' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                <option value="paypal" {{ old('metodo_pago') == 'paypal' ? 'selected' : '' }}>PayPal</option>
            </select>
        </div>

        <hr>

        <h4>Productos en el carrito:</h4>
        <ul>
            @foreach($carrito->items as $item)
            <li>{{ $item->producto->nombre }} - Cantidad: {{ $item->cantidad }} - Precio Unitario: {{ $item->precio_unitario }}€</li>
            @endforeach
        </ul>

        <button type="submit" class="btn btn-primary">Confirmar compra</button>
    </form>
</div>
@endsection


