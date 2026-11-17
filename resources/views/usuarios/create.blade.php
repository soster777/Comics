@extends('layouts.main')

@section('title', 'Nuevo usuario')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="titulo-seccion">Nuevo usuario</h2>

        <form action="{{ route('admin.usuarios.store') }}" method="POST" class="ficha">
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
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Repetir contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="is_admin" id="is_admin" value="1" class="form-check-input" @checked(old('is_admin'))>
                <label for="is_admin" class="form-check-label">Es administrador</label>
            </div>

            <div class="d-flex gap-2 justify-content-end mt-4">
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
