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
        $totalComics = Comic::count();
        $destacados = Comic::with(['autor', 'superheroes', 'editorial'])->orderBy('id', 'desc')->take(3)->get();

        return view('home', compact('totalComics', 'destacados'));
    }

    public function index(Request $request)
    {
        // lo que escribieron en el buscador del header (si no escribieron nada queda vacío)
        $buscar = trim((string) $request->input('buscar'));
        // la editorial que eligieron en el menú azul (si no eligieron, queda null)
        $editorialId = $request->integer('editorial_id') ?: null;

        $comics = Comic::with(['autor', 'superheroes', 'editorial'])
            // si escribieron algo, busco en el título y en la sinopsis
            ->when($buscar !== '', function ($consulta) use ($buscar) {
                // el OR va agrupado entre paréntesis para que no se coma el filtro de editorial
                $consulta->where(function ($q) use ($buscar) {
                    $q->where('comic', 'like', "%{$buscar}%")
                        ->orWhere('sinopsis', 'like', "%{$buscar}%");
                });
            })
            // si vino una editorial desde el menú, me quedo solo con esa
            ->when($editorialId, fn ($consulta) => $consulta->where('editorial_id', $editorialId))
            ->orderBy('id', 'desc')
            ->get();

        // la busco para poner su nombre en el título del listado
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
        // si la validación falla, Laravel vuelve al formulario con los errores y lo que habían escrito
        $datos = $this->validated($request);

        if ($request->hasFile('portada')) {
            // guarda el archivo en storage/app/public/portadas con un nombre aleatorio
            // y devuelve el path ("portadas/abc123.jpg"), que es lo que va a la base
            $datos['portada'] = $request->file('portada')->store('portadas', 'public');
        }

        // los superhéroes no van en la tabla comics: los saco del array antes de crear
        $superheroes = $datos['superheroes'];
        unset($datos['superheroes']);

        $comic = Comic::create($datos);

        // attach inserta una fila en comic_superheroe por cada superhéroe tildado.
        // va después del create porque necesita el id del cómic
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
        // with('superheroes') los trae para marcar los checkboxes que ya tiene
        $comic = Comic::with('superheroes')->findOrFail($id);
        $autores = Autor::orderBy('nombre')->get();
        $superheroes = Superheroe::orderBy('nombre')->get();
        $editoriales = Editorial::orderBy('nombre')->get();

        return view('comics.edit', compact('comic', 'autores', 'superheroes', 'editoriales'));
    }

    public function update(Request $request, $id)
    {
        $comic = Comic::findOrFail($id);
        $datos = $this->validated($request);

        if ($request->hasFile('portada')) {
            // subieron una portada nueva: borro la vieja del disco y guardo la nueva
            $this->borrarPortada($comic);
            $datos['portada'] = $request->file('portada')->store('portadas', 'public');
        } elseif ($request->boolean('quitar_portada')) {
            // tildaron "Quitar portada": borro el archivo y dejo la columna en null
            $this->borrarPortada($comic);
            $datos['portada'] = null;
        } else {
            // no tocaron la portada: la saco del array para no pisar la que ya estaba
            unset($datos['portada']);
        }

        $superheroes = $datos['superheroes'];
        unset($datos['superheroes']);

        $comic->update($datos);

        // sync deja en comic_superheroe exactamente los tildados: agrega los nuevos y borra los que se destildaron
        $comic->superheroes()->sync($superheroes);

        return redirect()->route('comics.show', $comic->id)->with('success', 'El cómic fue actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $comic = Comic::findOrFail($id);

        // primero el archivo, así no quedan imágenes sueltas en el disco
        $this->borrarPortada($comic);
        // detach borra las filas de este cómic en comic_superheroe (los superhéroes siguen existiendo)
        $comic->superheroes()->detach();
        $comic->delete();

        return redirect()->route('comics.index')->with('success', 'El cómic fue eliminado exitosamente.');
    }

    // las reglas en un solo lugar para el alta y la edición.
    // devuelve solo los campos validados, así no se cuela nada que no esté en la lista
    private function validated(Request $request): array
    {
        return $request->validate([
            'comic' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'autor_id' => 'required|exists:autores,id',
            // checkboxes name="superheroes[]": llega un array de ids, al menos uno
            'superheroes' => 'required|array|min:1',
            'superheroes.*' => 'exists:superheroes,id',
            'editorial_id' => 'required|exists:editoriales,id',
            'sinopsis' => 'nullable|string',
            // opcional; si viene, tiene que ser jpg o png de hasta 2 MB (max va en KB)
            'portada' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    }

    // borra el archivo de la portada del disco "public", si el cómic tiene una
    private function borrarPortada(Comic $comic): void
    {
        if ($comic->portada) {
            Storage::disk('public')->delete($comic->portada);
        }
    }
}
