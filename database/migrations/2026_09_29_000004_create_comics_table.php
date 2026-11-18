<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comics', function (Blueprint $table) {
            $table->id();
            $table->string('comic');
            $table->text('sinopsis')->nullable();
            $table->decimal('precio', 8, 2);
            $table->foreignId('autor_id')->constrained('autores')->cascadeOnDelete();
            $table->foreignId('editorial_id')->constrained('editoriales')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comics');
    }
};
