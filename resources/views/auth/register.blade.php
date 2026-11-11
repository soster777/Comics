@extends('layouts.main')

@section('title', 'Crear cuenta')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <h2 class="titulo-seccion">Crear cuenta</h2>

        <form action="{{ route('auth.register.process') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña (mínimo 8 caracteres)</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                {{-- la regla confirmed compara este campo con password --}}
                <label for="password_confirmation" class="form-label">Repetí la contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100">Crear cuenta</button>
        </form>

        <p class="text-center text-muted small mt-3">
            ¿Ya tenés cuenta? <a href="{{ route('auth.login') }}">Iniciá sesión</a>
        </p>
    </div>
</div>
@endsection
