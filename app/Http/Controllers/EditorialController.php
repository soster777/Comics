<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use Illuminate\Http\Request;

class EditorialController extends Controller
{
    public function index()
    {
        $editoriales = Editorial::withCount('comics')->orderBy('nombre')->get();

        return view('editoriales.index', compact('editoriales'));
    }

    public function create()
    {
        return view('editoriales.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255|unique:editoriales,nombre',
        ]);

        Editorial::create($datos);

        return redirect()->route('admin.editoriales.index')->with('success', 'La editorial fue creada exitosamente.');
    }

    public function edit($id)
    {
        $editorial = Editorial::findOrFail($id);

        return view('editoriales.edit', compact('editorial'));
    }

    public function update(Request $request, $id)
    {
        $editorial = Editorial::findOrFail($id);

        $datos = $request->validate([
            'nombre' => "required|string|max:255|unique:editoriales,nombre,{$id}",
        ]);

        $editorial->update($datos);

        return redirect()->route('admin.editoriales.index')->with('success', 'La editorial fue actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $editorial = Editorial::withCount('comics')->findOrFail($id);

        if ($editorial->comics_count > 0) {
            return redirect()->route('admin.editoriales.index')
                ->with('error', "No se puede eliminar {$editorial->nombre} porque tiene {$editorial->comics_count} cómic(s) cargado(s).");
        }

        $editorial->delete();

        return redirect()->route('admin.editoriales.index')->with('success', 'La editorial fue eliminada exitosamente.');
    }
}
