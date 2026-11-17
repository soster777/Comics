@extends('layouts.main')

@section('title', 'Inicio - Catálogo de Cómics')

@section('content')
{{-- carrusel de Bootstrap: pasa solo de un banner a otro (data-bs-ride) y también con las flechas.
     data-bs-pause="false": sigue pasando aunque el mouse esté encima --}}
<div id="banners" class="carousel slide banner mt-4" data-bs-ride="carousel" data-bs-pause="false">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#banners" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Banner 1"></button>
        <button type="button" data-bs-target="#banners" data-bs-slide-to="1" aria-label="Banner 2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="5000">
            {{-- el de Marvel lleva a los cómics de Marvel --}}
            <a href="{{ $marvel ? route('comics.index', ['editorial_id' => $marvel->id]) : route('comics.index') }}">
                <img src="{{ asset('img/banner-marvel.jpg') }}" alt="Envío gratis en compras de más de $80.000 - Marvel" class="d-block w-100">
            </a>
        </div>
        <div class="carousel-item" data-bs-interval="5000">
            <img src="{{ asset('img/banner-mercadopago.jpg') }}" alt="Aceptamos Mercado Pago" class="d-block w-100">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#banners" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#banners" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</div>

{{-- el h1 no se ve (el banner ya cumple ese lugar), pero lo leen los lectores de pantalla y Google --}}
<h1 class="visually-hidden">Catálogo de cómics</h1>

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