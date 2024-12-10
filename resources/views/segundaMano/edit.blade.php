@extends('plantilla')

@section('contenido')

<div class="container">
    <h1>Nuevo Juego de Segunda Mano</h1>

    <form action="{{ route('segundaMano.update', $segundaManoJuego->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Juego</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @else is-valid @enderror" id="nombre" value="{{ old('nombre', $segundaManoJuego->nombre) }}">
            @error('nombre')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @else is-valid @enderror" id="descripcion" rows="3">{{ old('descripcion', $segundaManoJuego->descripcion) }}</textarea>
            @error('descripcion')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Edición -->
        <div class="mb-3">
            <label for="edicion" class="form-label">Edición</label>
            <input type="text" name="edicion" class="form-control @error('edicion') is-invalid @else is-valid @enderror" id="edicion" value="{{ old('edicion', $segundaManoJuego->edicion) }}">
            @error('edicion')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Número de jugadores mínimo -->
        <div class="mb-3">
            <label for="num_jugadores_min" class="form-label">Número mínimo de jugadores</label>
            <input type="number" name="num_jugadores_min" class="form-control @error('num_jugadores_min') is-invalid @else is-valid @enderror" id="num_jugadores_min" value="{{ old('num_jugadores_min', $segundaManoJuego->num_jugadores_min) }}">
            @error('num_jugadores_min')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>


        <!-- Número de jugadores máximo -->
        <div class="mb-3">
            <label for="num_jugadores_max" class="form-label">Número máximo de jugadores</label>
            <input type="number" name="num_jugadores_max" class="form-control @error('num_jugadores_max') is-invalid @else is-valid @enderror" id="num_jugadores_max" value="{{ old('num_jugadores_max', $segundaManoJuego->num_jugadores_max) }}">
            @error('num_jugadores_max')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Edad recomendada -->
        <div class="mb-3">
            <label for="edad_recomendada" class="form-label">Edad recomendada</label>
            <input type="number" name="edad_recomendada" class="form-control @error('edad_recomendada') is-invalid @else is-valid @enderror" id="edad_recomendada" value="{{ old('edad_recomendada', $segundaManoJuego->edad_recomendada) }}">
            @error('edad_recomendada')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Duración aproximada -->
        <div class="mb-3">
            <label for="duracion_aprox" class="form-label">Duración aproximada (minutos)</label>
            <input type="number" name="duracion_aprox" class="form-control @error('duracion_aprox') is-invalid @else is-valid @enderror" id="duracion_aprox" value="{{ old('duracion_aprox', $segundaManoJuego->duracion_aprox) }}">
            @error('duracion_aprox')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Editor -->
        <div class="mb-3">
            <label for="editor" class="form-label">Editor</label>
            <input type="text" name="editor" class="form-control @error('editor') is-invalid @else is-valid @enderror" id="editor" value="{{ old('editor', $segundaManoJuego->editor) }}">
            @error('editor')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Diseñador -->
        <div class="mb-3">
            <label for="disenador" class="form-label">Diseñador</label>
            <input type="text" name="disenador" class="form-control @error('disenador') is-invalid @else is-valid @enderror" id="disenador" value="{{ old('disenador', $segundaManoJuego->disenador) }}">
            @error('disenador')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Año de publicación -->
        <div class="mb-3">
            <label for="ano_publicacion" class="form-label">Año de publicación</label>
            <input type="number" name="ano_publicacion" class="form-control @error('ano_publicacion') is-invalid @else is-valid @enderror" id="ano_publicacion" value="{{ old('ano_publicacion', $segundaManoJuego->ano_publicacion) }}">
            @error('ano_publicacion')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Dureza -->
        <div class="mb-3">
            <label for="dureza" class="form-label">Dureza (1-5)</label>
            <input type="number" step="0.1" name="dureza" class="form-control @error('dureza') is-invalid @else is-valid @enderror" id="dureza" value="{{ old('dureza', $segundaManoJuego->dureza) }}">
            @error('dureza')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Precio -->
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control @error('precio') is-invalid @else is-valid @enderror" id="precio" value="{{ old('precio', $segundaManoJuego->precio) }}">
            @error('precio')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Imagen -->
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @else is-valid @enderror" id="imagen" accept="image/*" value="{{ old('imagen', $segundaManoJuego->imagen) }}">
            @error('imagen')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="btn btn-primary">Crear Juego</button>
    </form>
</div>

@endsection