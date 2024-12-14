@extends('plantilla')

@section('contenido')
<div class="container">
    <h1>Nuevo Juego</h1>

    <form action="{{ route('juegos.store') }}" method="POST" enctype="multipart/form-data" id="nuevoJuegoForm">
        @csrf

        <!-- Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Juego</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" value="{{ old('nombre') }}">
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" rows="3">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Edición -->
        <div class="mb-3">
            <label for="edicion" class="form-label">Edición</label>
            <input type="text" name="edicion" class="form-control @error('edicion') is-invalid @enderror" id="edicion" value="{{ old('edicion') }}">
            @error('edicion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Número de jugadores mínimo -->
        <div class="mb-3">
            <label for="num_jugadores_min" class="form-label">Número mínimo de jugadores</label>
            <input type="number" name="num_jugadores_min" class="form-control @error('num_jugadores_min') is-invalid @enderror" id="num_jugadores_min" value="{{ old('num_jugadores_min') }}">
            @error('num_jugadores_min')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Número de jugadores máximo -->
        <div class="mb-3">
            <label for="num_jugadores_max" class="form-label">Número máximo de jugadores</label>
            <input type="number" name="num_jugadores_max" class="form-control @error('num_jugadores_max') is-invalid @enderror" id="num_jugadores_max" value="{{ old('num_jugadores_max') }}">
            @error('num_jugadores_max')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Edad recomendada -->
        <div class="mb-3">
            <label for="edad_recomendada" class="form-label">Edad recomendada</label>
            <input type="number" name="edad_recomendada" class="form-control @error('edad_recomendada') is-invalid @enderror" id="edad_recomendada" value="{{ old('edad_recomendada') }}">
            @error('edad_recomendada')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Duración aproximada -->
        <div class="mb-3">
            <label for="duracion_aprox" class="form-label">Duración aproximada (minutos)</label>
            <input type="number" name="duracion_aprox" class="form-control @error('duracion_aprox') is-invalid @enderror" id="duracion_aprox" value="{{ old('duracion_aprox') }}">
            @error('duracion_aprox')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Editor -->
        <div class="mb-3">
            <label for="editor" class="form-label">Editor</label>
            <input type="text" name="editor" class="form-control @error('editor') is-invalid @enderror" id="editor" value="{{ old('editor') }}">
            @error('editor')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Diseñador -->
        <div class="mb-3">
            <label for="disenador" class="form-label">Diseñador</label>
            <input type="text" name="disenador" class="form-control @error('disenador') is-invalid @enderror" id="disenador" value="{{ old('disenador') }}">
            @error('disenador')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Año de publicación -->
        <div class="mb-3">
            <label for="ano_publicacion" class="form-label">Año de publicación</label>
            <input type="number" name="ano_publicacion" class="form-control @error('ano_publicacion') is-invalid @enderror" id="ano_publicacion" value="{{ old('ano_publicacion') }}">
            @error('ano_publicacion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Dureza -->
        <div class="mb-3">
            <label for="dureza" class="form-label">Dureza (1-5)</label>
            <input type="number" step="0.1" name="dureza" class="form-control @error('dureza') is-invalid @enderror" id="dureza" value="{{ old('dureza') }}">
            @error('dureza')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Precio -->
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control @error('precio') is-invalid @enderror" id="precio" value="{{ old('precio') }}">
            @error('precio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Rating -->
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-10)</label>
            <input type="number" step="0.01" name="rating" class="form-control @error('rating') is-invalid @enderror" id="rating" value="{{ old('rating') }}">
            @error('rating')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Imagen -->
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @enderror" id="imagen" accept="image/*">
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
        <button type="submit" class="btn btn-primary">Crear Juego</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('nuevoJuegoForm');
        const inputs = form.querySelectorAll('.form-control');

        const validateInput = (input) => {
            const name = input.name;
            const value = input.value.trim();
            let isValid = true;

            switch (name) {
                case 'nombre':
                    isValid = value.length > 0 && value.length <= 100;
                    break;
                case 'descripcion':
                    break;
                case 'edicion':
                    isValid = value.length <= 50;
                    break;
                case 'num_jugadores_min':
                case 'num_jugadores_max':
                case 'edad_recomendada':
                    isValid = Number(value) >= 1;
                    break;
                case 'duracion_aprox':
                case 'stock':
                    isValid = value === '' || Number(value) >= 0;
                    break;
                case 'editor':
                case 'disenador':
                    isValid = value.length <= 100;
                    break;
                case 'ano_publicacion':
                    const currentYear = new Date().getFullYear();
                    isValid = value === '' || (Number(value) >= 1000 && Number(value) <= currentYear);
                    break;
                case 'dureza':
                    isValid = value === '' || (Number(value) >= 1 && Number(value) <= 5);
                    break;
                case 'precio':
                    isValid = value === '' || Number(value) >= 1;
                    break;
                case 'rating':
                    isValid = value === '' || (Number(value) >= 1 && Number(value) <= 10);
                    break;
                case 'imagen':
                    isValid = input.files.length === 0 || /\.(jpe?g|png)$/i.test(input.files[0].name);
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
    });
</script>

@endsection
