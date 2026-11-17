<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// migración de datos: no cambia tablas, actualiza los precios de los cómics que ya están cargados.
// el seeder solo corre con la base vacía, así que sin esto la base de Render seguía con los precios viejos
return new class extends Migration
{
    // título => [precio nuevo, precio viejo]
    private array $precios = [
        'Spider-Man: Blue' => [32000, 8500],
        'Batman: Year One' => [38000, 9200],
        'The Dark Knight Returns' => [54000, 10500.50],
        'All-Star Superman' => [62000, 11000],
        'The Amazing Spider-Man: Orígenes' => [29000, 7800],
        'Batman: The Killing Joke' => [34000, 6900],
        'Superman/Batman: Enemigos públicos' => [36000, 9800],
    ];

    public function up(): void
    {
        foreach ($this->precios as $titulo => [$nuevo, $viejo]) {
            DB::table('comics')->where('comic', $titulo)->update(['precio' => $nuevo]);
        }
    }

    // el rollback deja los precios como estaban
    public function down(): void
    {
        foreach ($this->precios as $titulo => [$nuevo, $viejo]) {
            DB::table('comics')->where('comic', $titulo)->update(['precio' => $viejo]);
        }
    }
};
