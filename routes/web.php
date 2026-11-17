<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ComicController::class, 'home'])->name('home');

// login y registro: 'guest' solo deja pasar a quien NO inició sesión
// (si ya estás logueado te manda al inicio)
Route::middleware('guest')->group(function () {
    Route::get('/iniciar-sesion', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/iniciar-sesion', [AuthController::class, 'login'])->name('auth.login.process');
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/registro', [AuthController::class, 'register'])->name('auth.register.process');
});

// el logout va por POST y solo para quien tiene la sesión iniciada
Route::post('/cerrar-sesion', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// parte pública: cualquiera puede ver el listado, buscar y entrar al detalle
Route::get('/comics', [ComicController::class, 'index'])->name('comics.index');
Route::get('/comics/{id}', [ComicController::class, 'show'])->name('comics.show')->whereNumber('id');

// contacto: lo puede usar cualquiera, logueado o no
Route::get('/contacto', [ContactoController::class, 'create'])->name('contacto.create');
Route::post('/contacto', [ContactoController::class, 'store'])->name('contacto.store');

// historial del cliente: solo hace falta estar logueado
Route::get('/mis-consultas', [ContactoController::class, 'misConsultas'])->name('contacto.mis')->middleware('auth');

// backend: primero 'auth' (sin sesión te manda al login) y después 'admin' (si no sos admin, 403)
Route::middleware(['auth', 'admin'])->group(function () {
    // ABM de cómics
    Route::get('/comics/crear', [ComicController::class, 'create'])->name('comics.create');
    Route::post('/comics', [ComicController::class, 'store'])->name('comics.store');
    Route::get('/comics/{id}/editar', [ComicController::class, 'edit'])->name('comics.edit')->whereNumber('id');
    Route::put('/comics/{id}', [ComicController::class, 'update'])->name('comics.update')->whereNumber('id');
    Route::delete('/comics/{id}', [ComicController::class, 'destroy'])->name('comics.destroy')->whereNumber('id');

    // ABM de editoriales (las "categorías" del catálogo), todo bajo /admin
    Route::get('/admin/editoriales', [EditorialController::class, 'index'])->name('admin.editoriales.index');
    Route::get('/admin/editoriales/crear', [EditorialController::class, 'create'])->name('admin.editoriales.create');
    Route::post('/admin/editoriales', [EditorialController::class, 'store'])->name('admin.editoriales.store');
    Route::get('/admin/editoriales/{id}/editar', [EditorialController::class, 'edit'])->name('admin.editoriales.edit')->whereNumber('id');
    Route::put('/admin/editoriales/{id}', [EditorialController::class, 'update'])->name('admin.editoriales.update')->whereNumber('id');
    Route::delete('/admin/editoriales/{id}', [EditorialController::class, 'destroy'])->name('admin.editoriales.destroy')->whereNumber('id');

    // todas las consultas que llegaron por contacto
    Route::get('/admin/consultas', [ContactoController::class, 'index'])->name('admin.consultas.index');

    // gestión de usuarios
    Route::get('/admin/usuarios', [UserController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/admin/usuarios/crear', [UserController::class, 'create'])->name('admin.usuarios.create');
    Route::post('/admin/usuarios', [UserController::class, 'store'])->name('admin.usuarios.store');
    Route::get('/admin/usuarios/{id}/editar', [UserController::class, 'edit'])->name('admin.usuarios.edit')->whereNumber('id');
    Route::put('/admin/usuarios/{id}', [UserController::class, 'update'])->name('admin.usuarios.update')->whereNumber('id');
    Route::delete('/admin/usuarios/{id}', [UserController::class, 'destroy'])->name('admin.usuarios.destroy')->whereNumber('id');
});

// cualquier dirección que no existe: pasa por el grupo web (con sesión), así el 404 muestra el menú del que está logueado
Route::fallback(fn () => abort(404));
