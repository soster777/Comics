@extends('layouts.main')

@section('title', 'Página no encontrada')

@section('content')
<section class="bienvenida mt-4">
    <p class="error-numero">404</p>
    <h1>¡Plop! Esta página no existe</h1>
    <p class="text-muted mb-4">Puede que el cómic se haya borrado o que la dirección esté mal escrita.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Volver al inicio</a>
</section>
@endsection
