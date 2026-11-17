@extends('layouts.main')

@section('title', 'Nuevo cómic')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <h2 class="titulo-seccion">Nuevo cómic</h2>

        {{-- enctype multipart/form-data: sin esto el archivo de la portada no viaja --}}
        <form action="{{ route('comics.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">

                <div class="col-12">
                    <label for="comic" class="form-label">Título</label>
                    <input type="text" name="comic" id="comic" class="form-control @error('comic') is-invalid @enderror" value="{{ old('comic') }}">
                    @error('comic')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="precio" class="form-label">Precio de tapa</label>
                    <input type="number" step="0.01" name="precio" id="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio') }}">
                    @error('precio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="editorial_id" class="form-label">Editorial</label>
                    <select name="editorial_id" id="editorial_id" class="form-select @error('editorial_id') is-invalid @enderror">
                        <option value="">Elegí una editorial</option>
                        @foreach($editoriales as $editorial)
                            <option value="{{ $editorial->id }}" {{ old('editorial_id') == $editorial->id ? 'selected' : '' }}>{{ $editorial->nombre }}</option>
                        @endforeach
                    </select>
                    @error('editorial_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="autor_id" class="form-label">Autor</label>
                    {{-- al elegir "Otro" se muestra el campo para escribir el autor nuevo --}}
                    <select name="autor_id" id="autor_id" class="form-select @error('autor_id') is-invalid @enderror" onchange="document.getElementById('autor_nuevo').classList.toggle('d-none', this.value !== 'otro')">
                        <option value="">Elegí un autor</option>
                        @foreach($autores as $autor)
                            <option value="{{ $autor->id }}" {{ old('autor_id') == $autor->id ? 'selected' : '' }}>{{ $autor->nombre }}</option>
                        @endforeach
                        <option value="otro" {{ old('autor_id') === 'otro' ? 'selected' : '' }}>Otro...</option>
                    </select>
                    @error('autor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <input type="text" name="autor_nuevo" id="autor_nuevo" placeholder="Nombre del autor nuevo" aria-label="Nombre del autor nuevo" class="form-control mt-2 @error('autor_nuevo') is-invalid @enderror {{ old('autor_id') === 'otro' ? '' : 'd-none' }}" value="{{ old('autor_nuevo') }}">
                    @error('autor_nuevo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <span class="form-label d-block">Superhéroes (uno o más)</span>
                    {{-- checkboxes con name="superheroes[]": al servidor llega un array con los ids tildados --}}
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($superheroes as $superheroe)
                            <div class="form-check">
                                <input type="checkbox" name="superheroes[]" value="{{ $superheroe->id }}" id="superheroe_{{ $superheroe->id }}" class="form-check-input" {{ in_array($superheroe->id, old('superheroes', [])) ? 'checked' : '' }}>
                                <label for="superheroe_{{ $superheroe->id }}" class="form-check-label">{{ $superheroe->nombre }}</label>
                            </div>
                        @endforeach
                    </div>
                    <input type="text" name="superheroe_nuevo" placeholder="¿Otro? Escribí el nombre del superhéroe" aria-label="Superhéroe nuevo" class="form-control mt-2 @error('superheroe_nuevo') is-invalid @enderror" value="{{ old('superheroe_nuevo') }}">
                    @error('superheroe_nuevo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('superheroes')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="portada" class="form-label">Portada (opcional, JPG o PNG de hasta 2 MB)</label>
                    <input type="file" name="portada" id="portada" accept="image/jpeg,image/png" class="form-control @error('portada') is-invalid @enderror">
                    @error('portada')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="sinopsis" class="form-label">Sinopsis (opcional)</label>
                    <textarea name="sinopsis" id="sinopsis" rows="4" class="form-control @error('sinopsis') is-invalid @enderror">{{ old('sinopsis') }}</textarea>
                    @error('sinopsis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="d-flex gap-2 justify-content-end mt-4">
                <a href="{{ route('comics.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
