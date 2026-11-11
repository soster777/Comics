<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;

// formulario de contacto (público) y el historial de consultas (cliente y admin)
class ContactoController extends Controller
{
    // GET /contacto: muestra el formulario
    public function create()
    {
        return view('contacto.create');
    }

    // POST /contacto: valida y guarda la consulta
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string|max:2000',
        ]);

        // si la mandó alguien logueado, queda asociada a su usuario; si es invitado, queda en null
        $datos['user_id'] = $request->user()?->id;

        Consulta::create($datos);

        return redirect()->route('contacto.create')
            ->with('success', 'Recibimos tu consulta, te vamos a responder a '.$datos['email'].'.');
    }

    // GET /mis-consultas: el historial del cliente logueado (ruta con middleware auth)
    public function misConsultas(Request $request)
    {
        // usa la relación consultas() de User: solo trae las de este usuario
        $consultas = $request->user()->consultas()->latest()->get();

        return view('contacto.mis-consultas', compact('consultas'));
    }

    // GET /admin/consultas: el admin ve todas (ruta con middleware auth + admin)
    public function index()
    {
        $consultas = Consulta::with('user')->latest()->get();

        return view('contacto.index', compact('consultas'));
    }
}
