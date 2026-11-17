@extends('layouts.main')

@section('title', 'Editar editorial')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="titulo-seccion">Editar editorial</h2>

        <form action="{{ route('admin.editoriales.update', $editorial->id) }}" method="POST" class="ficha">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $editorial->nombre) }}" autofocus>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 justify-content-end mt-4">
                <a href="{{ route('admin.editoriales.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
