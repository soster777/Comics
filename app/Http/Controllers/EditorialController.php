<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use Illuminate\Http\Request;

// ABM de editoriales: son las "categorías" del catálogo (Editorial 1 a N Comic).
// todas sus rutas están dentro del grupo auth + admin
class EditorialController extends Controller
{
    public function index()
    {
        // withCount agrega comics_count a cada editorial sin traer todos los cómics
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
            // unique: no puede haber dos editoriales con el mismo nombre
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
            // el ",{$id}" del final le dice a unique que ignore a esta misma editorial,
            // si no, guardarla sin cambiar el nombre daría "ya está registrado"
            'nombre' => "required|string|max:255|unique:editoriales,nombre,{$id}",
        ]);

        $editorial->update($datos);

        return redirect()->route('admin.editoriales.index')->with('success', 'La editorial fue actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $editorial = Editorial::withCount('comics')->findOrFail($id);

        // si tiene cómics no la borro: avisarlo acá es más claro que el error de la base
        // (la FK editorial_id tiene restrictOnDelete, así que la base tampoco lo dejaría)
        if ($editorial->comics_count > 0) {
            return redirect()->route('admin.editoriales.index')
                ->with('error', "No se puede eliminar {$editorial->nombre} porque tiene {$editorial->comics_count} cómic(s) cargado(s).");
        }

        $editorial->delete();

        return redirect()->route('admin.editoriales.index')->with('success', 'La editorial fue eliminada exitosamente.');
    }
}
