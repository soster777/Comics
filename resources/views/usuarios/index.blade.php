@extends('layouts.main')

@section('title', 'Usuarios')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <h2 class="titulo-seccion">Usuarios</h2>

        <div class="text-end mb-3">
            <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">Nuevo usuario</a>
        </div>

        <div class="ficha">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th class="text-center">Consultas</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>
                            @if($usuario->is_admin)
                                <span class="badge text-bg-primary">Admin</span>
                            @else
                                <span class="badge text-bg-secondary">Cliente</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $usuario->consultas_count }}</td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-outline-secondary btn-sm">Editar</a>

                                {{-- a uno mismo no se le muestra el botón (igual el controlador lo frena) --}}
                                @if($usuario->id !== auth()->id())
                                    <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar este usuario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
