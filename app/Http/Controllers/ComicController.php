<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use App\Models\Comic;
use App\Models\Editorial;
use App\Models\Superheroe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComicController extends Controller
{
    public function home()
    {
        $destacados = Comic::with(['autor', 'superheroes', 'editorial'])->orderBy('id', 'desc')->take(4)->get();
        $marvel = Editorial::where('nombre', 'Marvel Comics')->first();

        return view('home', compact('destacados', 'marvel'));
    }

    public function index(Request $request)
    {
        $buscar = trim((string) $request->input('buscar'));
        $editorialId = $request->integer('editorial_id') ?: null;

        $comics = Comic::with(['autor', 'superheroes', 'editorial'])
            ->when($buscar !== '', function ($consulta) use ($buscar) {
                $consulta->where(function ($q) use ($buscar) {
                    $q->whereLike('comic', "%{$buscar}%")
                        ->orWhereLike('sinopsis', "%{$buscar}%");
                });
            })
            ->when($editorialId, fn ($consulta) => $consulta->where('editorial_id', $editorialId))
            ->orderBy('id', 'desc')
            ->get();

        $editorial = $editorialId ? Editorial::find($editorialId) : null;

        return view('comics.index', compact('comics', 'buscar', 'editorial'));
    }

    public function create()
    {
        $autores = Autor::orderBy('nombre')->get();
        $superheroes = Superheroe::orderBy('nombre')->get();
        $editoriales = Editorial::orderBy('nombre')->get();

        return view('comics.create', compact('autores', 'superheroes', 'editoriales'));
    }

    public function store(Request $request)
    {
        $datos = $this->guardarNuevos($this->validated($request));

        if ($request->hasFile('portada')) {
            $datos['portada'] = $request->file('portada')->store('portadas', 'public');
        }

        $superheroes = $datos['superheroes'];
        unset($datos['superheroes']);

        $comic = Comic::create($datos);

        $comic->superheroes()->attach($superheroes);

        return redirect()->route('comics.index')->with('success', 'El cómic fue registrado exitosamente.');
    }

    public function show($id)
    {
        $comic = Comic::with(['autor', 'superheroes', 'editorial'])->findOrFail($id);

        return view('comics.show', compact('comic'));
    }

    public function edit($id)
    {
        $comic = Comic::with('superheroes')->findOrFail($id);
        $autores = Autor::orderBy('nombre')->get();
        $superheroes = Superheroe::orderBy('nombre')->get();
        $editoriales = Editorial::orderBy('nombre')->get();

        return view('comics.edit', compact('comic', 'autores', 'superheroes', 'editoriales'));
    }

    public function update(Request $request, $id)
    {
        $comic = Comic::findOrFail($id);
        $datos = $this->guardarNuevos($this->validated($request));

        if ($request->hasFile('portada')) {
            $this->borrarPortada($comic);
            $datos['portada'] = $request->file('portada')->store('portadas', 'public');
        } elseif ($request->boolean('quitar_portada')) {
            $this->borrarPortada($comic);
            $datos['portada'] = null;
        } else {
            unset($datos['portada']);
        }

        $superheroes = $datos['superheroes'];
        unset($datos['superheroes']);

        $comic->update($datos);

        $comic->superheroes()->sync($superheroes);

        return redirect()->route('comics.show', $comic->id)->with('success', 'El cómic fue actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $comic = Comic::findOrFail($id);

        $this->borrarPortada($comic);
        $comic->superheroes()->detach();
        $comic->delete();

        return redirect()->route('comics.index')->with('success', 'El cómic fue eliminado exitosamente.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'comic' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'autor_id' => $request->input('autor_id') === 'otro' ? 'required' : 'required|exists:autores,id',
            'autor_nuevo' => 'required_if:autor_id,otro|nullable|string|max:255',
            'superheroes' => 'required_without:superheroe_nuevo|array',
            'superheroes.*' => 'exists:superheroes,id',
            'superheroe_nuevo' => 'nullable|string|max:255',
            'editorial_id' => $request->input('editorial_id') === 'otro' ? 'required' : 'required|exists:editoriales,id',
            'editorial_nueva' => 'required_if:editorial_id,otro|nullable|string|max:255',
            'sinopsis' => 'nullable|string',
            'portada' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    }

    private function guardarNuevos(array $datos): array
    {
        if ($datos['autor_id'] === 'otro') {
            $datos['autor_id'] = Autor::firstOrCreate(['nombre' => $datos['autor_nuevo']])->id;
        }

        if ($datos['editorial_id'] === 'otro') {
            $datos['editorial_id'] = Editorial::firstOrCreate(['nombre' => $datos['editorial_nueva']])->id;
        }

        $datos['superheroes'] = $datos['superheroes'] ?? [];
        if (! empty($datos['superheroe_nuevo'])) {
            $datos['superheroes'][] = Superheroe::firstOrCreate(['nombre' => $datos['superheroe_nuevo']])->id;
        }

        unset($datos['autor_nuevo'], $datos['editorial_nueva'], $datos['superheroe_nuevo']);

        return $datos;
    }

    private function borrarPortada(Comic $comic): void
    {
        if ($comic->portada) {
            Storage::disk('public')->delete($comic->portada);
        }
    }
}
