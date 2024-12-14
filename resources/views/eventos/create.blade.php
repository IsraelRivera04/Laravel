@extends('plantilla')

@section('contenido')
<div class="container mt-4">
   <h1>Crear Evento</h1>
   <form action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data" id="nuevoEventoForm">
       @csrf
       <div class="mb-3">
           <label for="nombre" class="form-label">Título</label>
           <input type="text" name="nombre" class="form-control" id="nombre" value="{{ old('nombre') }}">
           @error('nombre')
               <div class="invalid-feedback">{{ $message }}</div>
           @enderror
       </div>
       <div class="mb-3">
           <label for="descripcion" class="form-label">Descripción</label>
           <textarea name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
           @error('descripcion')
               <div class="invalid-feedback">{{ $message }}</div>
           @enderror
       </div>
       <div class="mb-3">
           <label for="fecha" class="form-label">Fecha</label>
           <input type="date" name="fecha" class="form-control" id="fecha" value="{{ old('fecha') }}">
           @error('fecha')
               <div class="invalid-feedback">{{ $message }}</div>
           @enderror
       </div>
       <div class="mb-3">
           <label for="hora_inicio" class="form-label">Hora de inicio</label>
           <input type="time" name="hora_inicio" class="form-control" id="hora_inicio" value="{{ old('hora_inicio') }}">
           @error('hora_inicio')
               <div class="invalid-feedback">{{ $message }}</div>
           @enderror
       </div>
       <div class="mb-3">
           <label for="hora_final" class="form-label">Hora de finalización</label>
           <input type="time" name="hora_final" class="form-control" id="hora_final" value="{{ old('hora_final') }}">
           @error('hora_final')
               <div class="invalid-feedback">{{ $message }}</div>
           @enderror
       </div>
       <div class="mb-3">
           <label for="ubicacion" class="form-label">Ubicación</label>
           <input type="text" name="ubicacion" class="form-control" id="ubicacion" value="{{ old('ubicacion') }}">
           @error('ubicacion')
               <div class="invalid-feedback">{{ $message }}</div>
           @enderror
       </div>
       <div class="mb-3">
           <label for="plazas" class="form-label">Número de plazas</label>
           <input type="number" name="plazas" class="form-control" id="plazas" value="{{ old('plazas') }}" min="1">
           @error('plazas')
               <div class="invalid-feedback">{{ $message }}</div>
           @enderror
       </div>
       <div class="mb-3">
           <label for="imagen" class="form-label">Imagen</label>
           <input type="file" name="imagen" class="form-control" id="imagen" accept="image/*">
           @error('imagen')
               <div class="invalid-feedback">{{ $message }}</div>
           @enderror
       </div>
       <button type="submit" class="btn btn-success">Guardar</button>
   </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('nuevoEventoForm');
        const inputs = form.querySelectorAll('.form-control');

        const validateInput = (input) => {
            const name = input.name;
            const value = input.value.trim();
            let isValid = true;

            switch (name) {
                case 'nombre':
                    isValid = value.length > 0 && value.length <= 255;
                    break;
                case 'descripcion':
                    break;
                case 'fecha':
                    isValid = value !== '';
                    break;
                case 'hora_inicio':
                    isValid = /^(?:[01]\d|2[0-3]):[0-5]\d$/.test(value);
                    break;
                case 'hora_final':
                    isValid = /^(?:[01]\d|2[0-3]):[0-5]\d$/.test(value) && value > document.querySelector('input[name="hora_inicio"]').value;
                    break;
                case 'ubicacion':
                    isValid = value.length <= 255;
                    break;
                case 'plazas':
                    isValid = value > 0;
                    break;
                case 'imagen':
                    if (input.files.length > 0) {
                        isValid = ['image/jpeg', 'image/png', 'image/jpg'].includes(input.files[0].type);
                    }
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


