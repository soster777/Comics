<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::withCount('consultas')->orderBy('name')->get();

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $usuario = new User([
            'name' => $datos['name'],
            'email' => $datos['email'],
            'password' => Hash::make($datos['password']),
        ]);
        $usuario->is_admin = $request->boolean('is_admin');
        $usuario->save();

        return redirect()->route('admin.usuarios.index')->with('success', 'El usuario fue creado exitosamente.');
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);

        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,{$id}",
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $usuario->name = $datos['name'];
        $usuario->email = $datos['email'];
        if (! empty($datos['password'])) {
            $usuario->password = Hash::make($datos['password']);
        }
        if ($usuario->id !== auth()->id()) {
            $usuario->is_admin = $request->boolean('is_admin');
        }
        $usuario->save();

        return redirect()->route('admin.usuarios.index')->with('success', 'El usuario fue actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->id === auth()->id()) {
            return redirect()->route('admin.usuarios.index')->with('error', 'No podés eliminar tu propio usuario.');
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'El usuario fue eliminado exitosamente.');
    }
}
