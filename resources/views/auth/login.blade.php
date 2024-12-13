@extends('plantilla')

@section('contenido')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center">Iniciar sesión</h1>
            <div class="card">
                <div class="card-header">Formulario de Login</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Nombre de Usuario</label>
                            
                            <div class="col-md-6">
                                <input id="username" type="text" name="username" 
                                    class="form-control" 
                                    value="{{ old('username') }}" 
                                    required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>
                            
                            <div class="col-md-6">
                                <input id="password" type="password" name="password" 
                                    class="form-control" 
                                    value="{{ old('password') }}" 
                                    required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Iniciar sesión
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('loginForm');
        const inputs = form.querySelectorAll('.form-control');

        inputs.faorEach(input => {
            input.addEventListener('blur', () => {
                if (input.value.trim() === '') {
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
