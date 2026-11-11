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
        Schema::table('comics', function (Blueprint $table) {
            // guarda solo el path dentro del disco "public" (ej. "portadas/abc123.jpg").
            // la imagen en sí vive en storage/app/public/portadas
            $table->string('portada')->nullable()->after('sinopsis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comics', function (Blueprint $table) {
            $table->dropColumn('portada');
        });
    }
};
