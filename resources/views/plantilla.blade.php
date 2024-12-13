<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juegos de Mesa</title>

    <link rel="icon" href="{{ asset('icono.png') }}" type="image/x-icon">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display:flex;
            flex-direction:column;
        }

        .container {
            flex:1;
            display: flex;
            flex-direction: column;
        }

        footer {
            width: 100%;
            margin-top: auto;
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 1rem;
        }
    </style>
</head>
<body>
    @include('partials.nav')

    <div class="container mt-4">
        <h1 class="mb-4">@yield('titulo')</h1>

        @yield('contenido')
    </div>

    <footer>
        <p>&copy; 2024 Lacrimosa Board Games. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('form-validator.js')}}"></script>
</body>
</html>
