<?php

namespace App\Providers;

use App\Models\Editorial;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Le paso las editoriales al layout para armar el menú azul.
        // Uso un composer y no View::share para que la consulta se haga
        // recién cuando se dibuja la vista (así no molesta al correr migrate).
        View::composer('layouts.main', function ($view) {
            $view->with('menuEditoriales', Editorial::orderBy('nombre')->get());
        });

        // directiva propia @admin ... @endadmin para las vistas:
        // lo de adentro solo se muestra si hay un usuario logueado y es admin.
        // ojo: esto solo esconde botones, lo que protege de verdad es el middleware de las rutas
        Blade::if('admin', fn () => auth()->user()?->is_admin);
    }
}
