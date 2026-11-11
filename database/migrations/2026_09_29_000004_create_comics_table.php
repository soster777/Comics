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
        Schema::create('comics', function (Blueprint $table) {
            $table->id();
            $table->string('comic');
            $table->text('sinopsis')->nullable();
            $table->decimal('precio', 8, 2);
            $table->foreignId('autor_id')->constrained('autores')->cascadeOnDelete();
            // los superhéroes ya no van acá: un cómic puede tener varios, así que van en la tabla comic_superheroe
            // restrict: la base no deja borrar una editorial que todavía tiene cómics
            // (con cascade se borraban todos sus cómics sin avisar)
            $table->foreignId('editorial_id')->constrained('editoriales')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comics');
    }
};