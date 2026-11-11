<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // GET /iniciar-sesion: solo muestra el formulario, no loguea a nadie
    public function showLogin()
    {
        return view('auth.login');
    }

    // POST /iniciar-sesion: recibe el formulario y chequea las credenciales
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Auth::attempt busca el usuario por email, compara la contraseña con el hash
        // guardado en la base y, si coincide, deja al usuario guardado en la sesión
        if (! Auth::attempt($credenciales)) {
            return back()
                ->withErrors(['email' => 'El email o la contraseña no son correctos.'])
                ->onlyInput('email');
        }

        // id de sesión nuevo una vez que se loguea
        $request->session()->regenerate();

        // intended() lo manda a la página que quería ver antes de que 'auth' lo frenara;
        // si no venía de ningún lado, al inicio
        return redirect()->intended(route('home'))
            ->with('success', 'Sesión iniciada. Hola, '.Auth::user()->name.'.');
    }

    // GET /registro: muestra el formulario de registro
    public function showRegister()
    {
        return view('auth.register');
    }

    // POST /registro: crea el usuario y lo deja logueado
    public function register(Request $request)
    {
        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            // confirmed pide un campo password_confirmation con el mismo valor
            'password' => 'required|string|min:8|confirmed',
        ]);

        // la contraseña se guarda hasheada, nunca en texto plano.
        // is_admin no se toca: queda en false por la migración, o sea que es cliente
        $usuario = User::create([
            'name' => $datos['name'],
            'email' => $datos['email'],
            'password' => Hash::make($datos['password']),
        ]);

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', 'Cuenta creada. Ya iniciaste sesión.');
    }

    // POST /cerrar-sesion
    public function logout(Request $request)
    {
        Auth::logout();

        // borro lo que había en la sesión y genero un token CSRF nuevo
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Cerraste sesión.');
    }
}
