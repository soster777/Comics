@extends('layouts.main')

@section('title', $comic->comic)

@section('content')
<div class="row justify-content-center g-5 my-2">

    <div class="col-10 col-md-4">
        <div class="portada portada-{{ $comic->editorial_id }}">
            @if($comic->portada_url)
                <img src="{{ $comic->portada_url }}" alt="Portada de {{ $comic->comic }}">
            @else
                <span>{{ $comic->comic }}</span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <h1 class="h3 fw-bold text-uppercase">{{ $comic->comic }}</h1>
        <p class="precio fs-4">Precio de tapa: $ {{ number_format($comic->precio, 2, ',', '.') }}</p>

        <dl class="row">
            <dt class="col-sm-4">Autor</dt>
            <dd class="col-sm-8">{{ $comic->autor->nombre }}</dd>

            <dt class="col-sm-4">Superhéroes</dt>
            {{-- $comic->superheroes es una colección: pluck saca los nombres y join los une con coma --}}
            <dd class="col-sm-8">{{ $comic->superheroes->pluck('nombre')->join(', ') }}</dd>

            <dt class="col-sm-4">Editorial</dt>
            <dd class="col-sm-8">{{ $comic->editorial->nombre }}</dd>
        </dl>

        <h2 class="h6 fw-bold">Sinopsis</h2>
        <p class="text-secondary">{{ $comic->sinopsis ?: 'Este cómic no tiene sinopsis.' }}</p>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('comics.index') }}" class="btn btn-outline-secondary">Volver</a>

            {{-- solo el admin ve editar y eliminar --}}
            @admin
                <a href="{{ route('comics.edit', $comic->id) }}" class="btn btn-primary">Editar</a>

                <form action="{{ route('comics.destroy', $comic->id) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar este cómic?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                </form>
            @endadmin
        </div>
    </div>

</div>
@endsection
