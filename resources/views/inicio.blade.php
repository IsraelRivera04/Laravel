@extends('plantilla')

@section('contenido')
<div class="container text-center">
    <h1 class="display-4 text-primary">¡Bienvenidos a Lacrimosa Board Games!</h1>
    <p class="lead text-muted">Esta es la página de inicio donde podrás encontrar toda la información sobre nuestra tienda y nuestros productos. Explora nuestros juegos de mesa, complementos y mucho más.</p>

    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <img src="/storage/paginaInicio.jpeg" class="card-img-top" alt="Logo de la tienda">
                <div class="card-body">
                    <h5 class="card-title">Tu tienda de confianza para juegos de mesa</h5>
                    <p class="card-text">Descubre juegos de mesa para todas las edades y gustos. Navega por nuestra selección de productos y encuentra lo que más te gusta.</p>
                    <a href="{{ route('juegos.index') }}" class="btn btn-primary btn-lg">Explorar Juegos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
