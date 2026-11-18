<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function create()
    {
        return view('contacto.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string|max:2000',
        ]);

        $datos['user_id'] = $request->user()?->id;

        Consulta::create($datos);

        return redirect()->route('contacto.create')
            ->with('success', 'Recibimos tu consulta, te vamos a responder a '.$datos['email'].'.');
    }

    public function misConsultas(Request $request)
    {
        $consultas = $request->user()->consultas()->latest()->get();

        return view('contacto.mis-consultas', compact('consultas'));
    }

    public function index()
    {
        $consultas = Consulta::with('user')->latest()->get();

        return view('contacto.index', compact('consultas'));
    }
}
