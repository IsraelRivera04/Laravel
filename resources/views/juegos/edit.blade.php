@extends('plantilla')

@section('contenido')

<div class="container">
    <h1>Editar Juego</h1>

    <form action="{{ route('juegos.update', $juego->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Juego</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @else is-valid @enderror" id="nombre" value="{{ old('nombre', $juego->nombre) }}">
            @error('nombre')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @else is-valid @enderror" id="descripcion" rows="3">{{ old('descripcion', $juego->descripcion) }}</textarea>
            @error('descripcion')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Edición -->
        <div class="mb-3">
            <label for="edicion" class="form-label">Edición</label>
            <input type="text" name="edicion" class="form-control @error('edicion') is-invalid @else is-valid @enderror" id="edicion" value="{{ old('edicion', $juego->edicion) }}">
            @error('edicion')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Número de jugadores mínimo -->
        <div class="mb-3">
            <label for="num_jugadores_min" class="form-label">Número mínimo de jugadores</label>
            <input type="number" name="num_jugadores_min" class="form-control @error('num_jugadores_min') is-invalid @else is-valid @enderror" id="num_jugadores_min" value="{{ old('num_jugadores_min', $juego->num_jugadores_min) }}">
            @error('num_jugadores_min')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>


        <!-- Número de jugadores máximo -->
        <div class="mb-3">
            <label for="num_jugadores_max" class="form-label">Número máximo de jugadores</label>
            <input type="number" name="num_jugadores_max" class="form-control @error('num_jugadores_max') is-invalid @else is-valid @enderror" id="num_jugadores_max" value="{{ old('num_jugadores_max', $juego->num_jugadores_max) }}">
            @error('num_jugadores_max')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Edad recomendada -->
        <div class="mb-3">
            <label for="edad_recomendada" class="form-label">Edad recomendada</label>
            <input type="number" name="edad_recomendada" class="form-control @error('edad_recomendada') is-invalid @else is-valid @enderror" id="edad_recomendada" value="{{ old('edad_recomendada', $juego->edad_recomendada) }}">
            @error('edad_recomendada')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Duración aproximada -->
        <div class="mb-3">
            <label for="duracion_aprox" class="form-label">Duración aproximada (minutos)</label>
            <input type="number" name="duracion_aprox" class="form-control @error('duracion_aprox') is-invalid @else is-valid @enderror" id="duracion_aprox" value="{{ old('duracion_aprox', $juego->duracion_aprox) }}">
            @error('duracion_aprox')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Editor -->
        <div class="mb-3">
            <label for="editor" class="form-label">Editor</label>
            <input type="text" name="editor" class="form-control @error('editor') is-invalid @else is-valid @enderror" id="editor" value="{{ old('editor', $juego->editor) }}">
            @error('editor')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Diseñador -->
        <div class="mb-3">
            <label for="disenador" class="form-label">Diseñador</label>
            <input type="text" name="disenador" class="form-control @error('disenador') is-invalid @else is-valid @enderror" id="disenador" value="{{ old('disenador', $juego->disenador) }}">
            @error('disenador')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Año de publicación -->
        <div class="mb-3">
            <label for="ano_publicacion" class="form-label">Año de publicación</label>
            <input type="number" name="ano_publicacion" class="form-control @error('ano_publicacion') is-invalid @else is-valid @enderror" id="ano_publicacion" value="{{ old('ano_publicacion', $juego->ano_publicacion) }}">
            @error('ano_publicacion')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Dureza -->
        <div class="mb-3">
            <label for="dureza" class="form-label">Dureza (1-5)</label>
            <input type="number" step="0.1" name="dureza" class="form-control @error('dureza') is-invalid @else is-valid @enderror" id="dureza" value="{{ old('dureza', $juego->dureza) }}">
            @error('dureza')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Precio -->
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control @error('precio') is-invalid @else is-valid @enderror" id="precio" value="{{ old('precio', $juego->precio) }}">
            @error('precio')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Rating -->
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-10)</label>
            <input type="number" step="0.01" name="rating" class="form-control @error('rating') is-invalid @else is-valid @enderror" id="rating" value="{{ old('rating', $juego->rating) }}">
            @error('rating')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Imagen -->
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @else is-valid @enderror" id="imagen" accept="image/*" value="{{ old('imagen') }}">
            @error('imagen')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Stock -->
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control @error('stock') is-invalid @else is-valid @enderror" id="stock" value="{{ old('stock', $juego->stock) }}">
            @error('stock')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botón de envío -->
        @can('update', $juego)
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        @endcan
    </form>
</div>

@endsection
