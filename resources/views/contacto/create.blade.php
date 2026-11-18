@extends('layouts.main')

@section('title', 'Contacto')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <h2 class="titulo-seccion">Contacto</h2>

        <form action="{{ route('contacto.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', auth()->user()?->name) }}">
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()?->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="mensaje" class="form-label">Mensaje</label>
                <textarea name="mensaje" id="mensaje" rows="5" class="form-control @error('mensaje') is-invalid @enderror">{{ old('mensaje') }}</textarea>
                @error('mensaje')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Enviar consulta</button>
        </form>

        @guest
            <p class="text-center text-muted small mt-3">
                <a href="{{ route('auth.login') }}">Iniciá sesión</a> para ver el historial de tus consultas.
            </p>
        @endguest
    </div>
</div>
@endsection
