@extends('layouts.main')

@section('title', 'Editoriales')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h2 class="titulo-seccion">Editoriales</h2>

        <div class="text-end mb-3">
            <a href="{{ route('admin.editoriales.create') }}" class="btn btn-primary">Nueva editorial</a>
        </div>

        @if($editoriales->isEmpty())
            <p class="text-center text-muted my-5">Todavía no hay editoriales cargadas.</p>
        @else
            <div class="ficha">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th class="text-center">Cómics</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($editoriales as $editorial)
                        <tr>
                            <td>{{ $editorial->nombre }}</td>
                            <td class="text-center">{{ $editorial->comics_count }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.editoriales.edit', $editorial->id) }}" class="btn btn-outline-secondary btn-sm">Editar</a>

                                    <form action="{{ route('admin.editoriales.destroy', $editorial->id) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar esta editorial?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        @endif
    </div>
</div>
@endsection
