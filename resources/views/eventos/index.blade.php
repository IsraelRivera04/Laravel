@extends('plantilla')

@section('contenido')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Eventos</h1>
        @can('create', App\Models\Evento::class)
            <a href="{{ route('eventos.create') }}" class="btn btn-primary">+ Crear Evento</a>
        @endcan
    </div>

    <div class="row g-4">
        @forelse ($eventos as $evento)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="position-relative">
                        @if ($evento->imagen)
                            <img src="{{ $evento->imagen }}" class="card-img-top rounded-top" alt="{{ $evento->nombre }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default_evento.jpg') }}" class="card-img-top rounded-top" alt="Imagen por defecto" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="position-absolute top-0 start-0 bg-dark text-white px-3 py-1 rounded-end">
                            {{ \Carbon\Carbon::parse($evento->fecha)->format('d M, Y') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-primary fw-bold">{{ $evento->nombre }}</h5>
                        <p class="card-text text-muted small mb-2">
                            {{ \Illuminate\Support\Str::limit($evento->descripcion, 80, '...') }}
                        </p>
                        <p class="text-muted small">Creado por: {{ $evento->usuario->username }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">
                                @if ($evento->ubicacion)
                                    📍 {{ \Illuminate\Support\Str::limit($evento->ubicacion, 20, '...') }}
                                @else
                                    🌍 Ubicación no especificada
                                @endif
                            </span>
                            <a href="{{ route('eventos.show', $evento->id) }}" class="btn btn-sm btn-outline-primary">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">No hay eventos disponibles.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
