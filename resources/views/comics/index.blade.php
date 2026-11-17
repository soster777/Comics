@extends('layouts.main')

@section('title', 'Listado de cómics')

@section('content')
<h2 class="titulo-seccion">
    @if($editorial)
        Cómics de {{ $editorial->nombre }}
    @else
        Todos los cómics
    @endif
</h2>

@if($buscar !== '')
    <p class="text-muted">
        Resultados para "{{ $buscar }}": {{ $comics->count() }}.
        <a href="{{ route('comics.index', $editorial ? ['editorial_id' => $editorial->id] : []) }}">Limpiar búsqueda</a>
    </p>
@endif

@if($comics->isEmpty())
    <p class="text-center text-muted my-5">
        @if($buscar !== '' || $editorial)
            No encontramos cómics con esos filtros.
        @else
            Todavía no hay cómics cargados.
        @endif
    </p>
@else
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
        @foreach($comics as $comic)
            <div class="col">
                @include('comics._tarjeta', ['comic' => $comic])
            </div>
        @endforeach
    </div>
@endif
@endsection
