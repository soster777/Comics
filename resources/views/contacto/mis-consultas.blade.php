@extends('layouts.main')

@section('title', 'Mis consultas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h2 class="titulo-seccion">Mis consultas</h2>

        @forelse($consultas as $consulta)
            <div class="border p-3 mb-3">
                <p class="small text-muted mb-1">{{ $consulta->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-0">{{ $consulta->mensaje }}</p>
            </div>
        @empty
            <p class="text-center text-muted my-5">
                Todavía no mandaste consultas. <a href="{{ route('contacto.create') }}">Escribinos</a>.
            </p>
        @endforelse
    </div>
</div>
@endsection
