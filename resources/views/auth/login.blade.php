@extends('layouts.main')

@section('title', 'Iniciar sesión')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <h2 class="titulo-seccion">Iniciar sesión</h2>

        {{-- el formulario lo muestra showLogin (GET) y lo procesa login (POST) --}}
        <form action="{{ route('auth.login.process') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Contraseña</label>
                {{-- la contraseña nunca se rellena con old() --}}
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>

        <p class="text-center text-muted small mt-3">
            ¿No tenés cuenta? <a href="{{ route('auth.register') }}">Registrate</a>
        </p>
    </div>
</div>
@endsection
