@extends('plantilla')

@section('contenido')

<div class="container">
    <h1>Nuevo Complemento</h1>

    <form action="{{ route('complementos.store') }}" method="POST" enctype="multipart/form-data" id="nuevoComplementoForm">
        @csrf

        <!-- Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Complemento</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" value="{{ old('nombre') }}" maxlength="255" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" rows="3" maxlength="1000" required>{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Precio -->
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control @error('precio') is-invalid @enderror" id="precio" value="{{ old('precio') }}" required>
            @error('precio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Imagen -->
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @enderror" id="imagen" accept="image/jpeg,image/png,image/jpg">
            @error('imagen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Stock -->
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" id="stock" value="{{ old('stock') }}">
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="btn btn-primary">Crear Complemento</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('nuevoComplementoForm');
        const inputs = form.querySelectorAll('.form-control');

        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                let isValid = true;

                if (input.name === 'nombre' && (input.value.trim() === '' || input.value.length > 255)) {
                    isValid = false;
                } else if (input.name === 'descripcion' && (input.value.trim() === '' || input.value.length > 1000)) {
                    isValid = false;
                } else if (input.name === 'precio' && (input.value.trim() === '' || isNaN(parseFloat(input.value)))) {
                    isValid = false;
                } else if (input.name === 'imagen' && input.files.length > 0) {
                    const file = input.files[0];
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!validTypes.includes(file.type) || file.size > 2048 * 1024) {
                        isValid = false;
                    }
                } else if (input.name === 'stock' && input.value.trim() !== '' && isNaN(parseInt(input.value))) {
                    isValid = false;
                }

                if (!isValid) {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                }
            });
        });
    });
</script>

@endsection
