@extends('plantilla')

@section('contenido')
<div class="container">
    <h2>Finalizar compra</h2>
    <form action="{{ route('compra.procesar') }}" method="POST" id="finalizar-compra-form">
        @csrf
        <div class="form-group">
            <label for="direccion">Dirección de Envío</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion') }}" required>
            @error('direccion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}" required>
            @error('telefono')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('finalizar-compra-form');
        const inputs = form.querySelectorAll('.form-control');

        const validateInput = (input) => {
            const name = input.name;
            const value = input.value.trim();
            let isValid = true;

            switch (name) {
                case 'direccion':
                    isValid = value.length > 0;
                    break;
                case 'telefono':
                    isValid = /^\d{9}$/.test(value); 
                    break;
            }

            if (isValid) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
            }
        };

        inputs.forEach(input => {
            input.addEventListener('blur', () => validateInput(input));
        });

        form.addEventListener('submit', function (e) {
            let valid = true;
            inputs.forEach(input => {
                validateInput(input);
                if (input.classList.contains('is-invalid')) {
                    valid = false;
                }
            });

            if (!valid) {
                e.preventDefault(); 
            }
        });
    });
</script>
@endsection



