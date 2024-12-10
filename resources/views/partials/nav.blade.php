<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('inicio') }}">
            <img src="{{ asset('icono.png') }}" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
            Lacrimosa Board Games
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('juegos.index') }}">Juegos</a>
                </li>
                @if(Auth::user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('juegos.create') }}">Nuevo Juego</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('complementos.index') }}">Complementos</a>
                </li>
                @if(Auth::user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('complementos.create') }}">Nuevo Complemento</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('segundaMano.index') }}">Juegos Segunda Mano</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('segundaMano.create') }}">Nuevo Juego Segunda Mano</a>
                </li>
                @endauth
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('eventos.index') }}">Eventos</a>
                </li>
                @endauth
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Registrarme</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                @endguest

                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @endauth
            </ul>

            @auth
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('carrito.index') }}">
                        Carrito
                        <span class="badge bg-secondary">
                            {{ Auth::user()->carritoItems->sum('cantidad') }}
                        </span>
                    </a>
                </li>
            </ul>
            @endauth
        </div>
    </div>
</nav>
