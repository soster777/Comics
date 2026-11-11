<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // tabla pivote del muchos a muchos: cada fila une un cómic con un superhéroe.
        // el nombre sigue la convención de Laravel: los dos modelos en singular y en orden alfabético
        Schema::create('comic_superheroe', function (Blueprint $table) {
            // si se borra el cómic o el superhéroe, se borran sus filas acá (no el otro lado)
            $table->foreignId('comic_id')->constrained('comics')->cascadeOnDelete();
            $table->foreignId('superheroe_id')->constrained('superheroes')->cascadeOnDelete();
            // clave primaria compuesta: el mismo par no se puede repetir
            $table->primary(['comic_id', 'superheroe_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comic_superheroe');
    }
};
