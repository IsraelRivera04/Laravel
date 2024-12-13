@extends('plantilla')

@section('contenido')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <h1 class="text-center">¡Regístrate!</h1>
            <div class="card">
                <div class="card-header">Formulario de Registro</div>

                <div class="card-body">
                <form method="POST" action="{{ route('register') }}" id="loginForm">
                        @csrf
                        <!-- username -->
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Nombre de Usuario</label>
                            <div class="col-md-6">
                                <input id="username" type="text" name="username" class="form-control" value="{{ old('username') }}">
                                <div id="usernameFeedback" class="feedback"></div>
                            </div>
                        </div>

                        <!-- email -->
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Correo Electrónico</label>
                            <div class="col-md-6">
                                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}">
                                <div id="emailFeedback" class="feedback"></div>
                            </div>
                        </div>

                        <!-- password -->
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>
                            <div class="col-md-6">
                                <input id="password" type="password" name="password" class="form-control">
                            </div>
                        </div>

                        <!-- password_confirmation -->
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">Confirmar Contraseña</label>
                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Registrarse</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#username').on('blur', function() {
            let username = $(this).val();

            if (username.length > 0) {
                $.ajax({
                    url: '{{ route('usuarioUnico') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        username: username
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#username').addClass('is-invalid').removeClass('is-valid');
                            $('#usernameFeedback').text('Este nombre de usuario ya está en uso').addClass('text-danger').removeClass('text-success');
                        } else {
                            $('#username').addClass('is-valid').removeClass('is-invalid');
                            $('#usernameFeedback').text('Nombre de usuario disponible').addClass('text-success').removeClass('text-danger');
                        }
                    }
                });
            }
        });

        $('#email').on('blur', function() {
            let email = $(this).val();

            if (email.length > 0) {
                $.ajax({
                    url: '{{ route('emailUnico') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#email').addClass('is-invalid').removeClass('is-valid');
                            $('#emailFeedback').text('Este correo electrónico ya está en uso').addClass('text-danger').removeClass('text-success');
                        } else {
                            $('#email').addClass('is-valid').removeClass('is-invalid');
                            $('#emailFeedback').text('Correo electrónico disponible').addClass('text-success').removeClass('text-danger');
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
