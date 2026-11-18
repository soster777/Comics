<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Catálogo de Cómics')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Ubuntu+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/estilos.css') }}" rel="stylesheet">
</head>
<body>

    <header class="border-bottom">
        <div class="container py-3">
            <div class="row align-items-center g-3">

                <div class="col-12 col-md-4 order-2 order-md-1">
                    <form action="{{ route('comics.index') }}" method="GET">
                        @if(request('editorial_id'))
                            <input type="hidden" name="editorial_id" value="{{ request('editorial_id') }}">
                        @endif
                        <div class="input-group">
                            <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar cómic">
                            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                </div>

                <div class="col-12 col-md-4 order-1 order-md-2 text-center">
                    <a href="{{ route('home') }}" class="logo">
                        Cómics
                    </a>
                </div>

                <div class="col-12 col-md-4 order-3">
                    <div class="dropdown text-md-end">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Mi cuenta">
                            <i class="bi bi-person-circle fs-5"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @guest
                                <li><a class="dropdown-item" href="{{ route('auth.login') }}">Iniciar sesión</a></li>
                                <li><a class="dropdown-item" href="{{ route('auth.register') }}">Registrarse</a></li>
                            @endguest

                            @auth
                                <li>
                                    <span class="dropdown-item-text small text-muted">
                                        Hola, {{ auth()->user()->name }}
                                        @admin<span class="badge text-bg-primary ms-1">Admin</span>@endadmin
                                    </span>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('auth.logout') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Cerrar sesión</button>
                                    </form>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <nav class="menu-azul">
        <div class="container">
            <ul class="nav justify-content-center">
                @admin
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('comics.index') ? 'active' : '' }}" href="{{ route('comics.index') }}">Cómics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('comics.create') ? 'active' : '' }}" href="{{ route('comics.create') }}">Nuevo cómic</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.editoriales.*') ? 'active' : '' }}" href="{{ route('admin.editoriales.index') }}">Editoriales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.consultas.*') ? 'active' : '' }}" href="{{ route('admin.consultas.index') }}">Consultas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}" href="{{ route('admin.usuarios.index') }}">Usuarios</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('comics.index') && !request('editorial_id') ? 'active' : '' }}" href="{{ route('comics.index') }}">Todos los cómics</a>
                </li>
                @foreach($menuEditoriales as $editorial)
                    <li class="nav-item">
                        <a class="nav-link {{ request('editorial_id') == $editorial->id ? 'active' : '' }}" href="{{ route('comics.index', ['editorial_id' => $editorial->id]) }}">{{ $editorial->nombre }}</a>
                    </li>
                @endforeach
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contacto.create') ? 'active' : '' }}" href="{{ route('contacto.create') }}">Contacto</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contacto.mis') ? 'active' : '' }}" href="{{ route('contacto.mis') }}">Mis consultas</a>
                    </li>
                @endauth
                @endadmin
            </ul>
        </div>
    </nav>

    @yield('banner')

    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <main class="container pb-4">
        @yield('content')
    </main>

    <footer class="pt-4 pb-3 mt-4">
        <div class="container">
            <div class="row g-4 text-center text-md-start">
                <div class="col-md-4">
                    <p class="footer-titulo">Cómics</p>
                    <p class="small mb-0">El catálogo de cómics de Marvel, DC y más.</p>
                </div>
                <div class="col-md-4">
                    <p class="footer-titulo">Contacto</p>
                    <ul class="list-unstyled small mb-0">
                        <li><i class="bi bi-envelope me-1"></i><a href="mailto:contactocomics@gmail.com">contactocomics@gmail.com</a></li>
                        <li><i class="bi bi-chat-dots me-1"></i><a href="{{ route('contacto.create') }}">Formulario de contacto</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <p class="footer-titulo">Redes sociales</p>
                    <a href="https://www.instagram.com/comics_ar" target="_blank" rel="noopener" class="small"><i class="bi bi-instagram me-1"></i>@comics_ar</a>
                </div>
            </div>
            <hr>
            <p class="small text-center mb-0">&copy; {{ date('Y') }} Catálogo de cómics. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
