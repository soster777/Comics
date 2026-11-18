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
    }

    public function boot(): void
    {
        View::composer('layouts.main', function ($view) {
            $view->with('menuEditoriales', Editorial::orderBy('nombre')->get());
        });

        Blade::if('admin', fn () => auth()->user()?->is_admin);
    }
}
