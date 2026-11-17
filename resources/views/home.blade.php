@extends('layouts.main')

@section('title', 'Inicio - Catálogo de Cómics')

@section('content')
{{-- banner de la promo: al hacer clic lleva a los cómics de Marvel --}}
<a href="{{ $marvel ? route('comics.index', ['editorial_id' => $marvel->id]) : route('comics.index') }}" class="banner d-block mt-4">
    <img src="{{ asset('img/banner-marvel.jpg') }}" alt="Envío gratis en compras de más de $80.000 - Marvel" class="img-fluid">
</a>

<section class="bienvenida mt-4">
    <h1 class="fw-bold">Catálogo de cómics</h1>
    @admin<p class="text-muted mb-4">Hay {{ $totalComics }} cómics cargados. Podés verlos, agregar nuevos, editarlos o eliminarlos.</p>@endadmin
    <a href="{{ route('comics.index') }}" class="btn btn-primary">Ver todos los cómics</a>
</section>

<h2 class="titulo-seccion">Últimos agregados</h2>

<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
    @forelse($destacados as $comic)
        <div class="col">
            @include('comics._tarjeta', ['comic' => $comic])
        </div>
    @empty
        <p class="text-center text-muted">Todavía no hay cómics cargados.</p>
    @endforelse
</div>
@endsection