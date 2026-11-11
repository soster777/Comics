@extends('layouts.main')

@section('title', 'Consultas recibidas')

@section('content')
<h2 class="titulo-seccion">Consultas recibidas</h2>

@if($consultas->isEmpty())
    <p class="text-center text-muted my-5">Todavía no llegó ninguna consulta.</p>
@else
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Cuenta</th>
                <th>Mensaje</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultas as $consulta)
                <tr>
                    <td class="text-nowrap">{{ $consulta->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $consulta->nombre }}</td>
                    <td>{{ $consulta->email }}</td>
                    {{-- user viene del with('user') del controlador; si la mandó un invitado es null --}}
                    <td>{{ $consulta->user ? 'Cliente registrado' : 'Invitado' }}</td>
                    <td>{{ $consulta->mensaje }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
