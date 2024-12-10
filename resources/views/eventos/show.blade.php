@extends('plantilla')

@section('contenido')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h1 class="mb-0">{{ $evento->nombre }}</h1>
        </div>
        <div class="card-body">
            @if ($evento->imagen)
                <img src="{{ $evento->imagen }}" alt="{{ $evento->nombre }}" class="img-fluid my-3 rounded">
            @else
                <img src="{{ asset('images/default_evento.jpg') }}" alt="Imagen por defecto" class="img-fluid my-3 rounded">
            @endif

            <p><strong>Descripción:</strong> {{ $evento->descripcion }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</p>
            <p><strong>Ubicación:</strong> {{ $evento->ubicacion ?? 'No especificada' }}</p>
            <p><strong>Plazas disponibles:</strong> 
                <span class="{{ $evento->plazas > $evento->participantes()->count() ? 'text-success' : 'text-danger' }}">
                    {{ $evento->plazas - $evento->participantes()->count() }} / {{ $evento->plazas }}
                </span>
            </p>

            <div class="mt-3">
                @auth
                    @if ($evento->participantes->contains(auth()->user()))
                        <p class="text-success">Ya estás inscrito en este evento.</p>
                    @elseif ($evento->plazas > $evento->participantes()->count())
                        <form action="{{ route('eventos.inscribirse', $evento->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-primary">Inscribirme</button>
                        </form>
                    @else
                        <p class="text-danger">No quedan plazas disponibles.</p>
                    @endif
                @else
                    <p>Inicia sesión para inscribirte al evento.</p>
                @endauth
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h3>Participantes</h3>
        <ul class="list-group">
            @forelse ($evento->participantes as $participante)
                <li class="list-group-item d-flex align-items-center">
                    <i class="bi bi-person-circle me-2"></i>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
                    {{ $participante->username }}
                </li>
            @empty
                <li class="list-group-item">No hay participantes aún.</li>
            @endforelse
        </ul>
    </div>

    <a href="{{ route('eventos.index') }}" class="btn btn-secondary mt-4">Volver a la lista</a>
</div>
@endsection

