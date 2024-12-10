@extends('plantilla')

@section('contenido')

<div class="container">
    <h1>Editar Complemento</h1>

    <form action="{{ route('complementos.update', $complemento->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Complemento</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" value="{{ old('nombre', $complemento->nombre) }}">
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" rows="3">{{ old('descripcion', $complemento->descripcion) }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Precio -->
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control @error('precio') is-invalid @enderror" id="precio" value="{{ old('precio', $complemento->precio) }}">
            @error('precio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Imagen -->
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @enderror" id="imagen" accept="image/jpeg,image/png">
            @error('imagen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Stock -->
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" id="stock" value="{{ old('stock', $complemento->stock) }}">
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botón de envío -->
        @can('update', $complemento)
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        @endcan
    </form>
</div>

@endsection
