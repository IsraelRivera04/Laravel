@extends('plantilla')

@section('contenido')

<div class="container">
    <h1>Nuevo Complemento</h1>

    <form action="{{ route('complementos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Complemento</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @else is-valid @enderror" id="nombre" value="{{ old('nombre') }}">
            @error('nombre')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @else is-valid @enderror" id="descripcion" rows="3">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Precio -->
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control @error('precio') is-invalid @else is-valid @enderror" id="precio" value="{{ old('precio') }}">
            @error('precio')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Imagen -->
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @else is-valid @enderror" id="imagen" accept="image/jpeg,image/png" value="{{ old('imagen') }}">
            @error('imagen')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Stock -->
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control @error('stock') is-invalid @else is-valid @enderror" id="stock" value="{{ old('stock') }}">
            @error('stock')
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="btn btn-primary">Crear Complemento</button>
    </form>
</div>

@endsection