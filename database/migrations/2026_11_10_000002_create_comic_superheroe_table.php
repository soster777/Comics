<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comic_superheroe', function (Blueprint $table) {
            $table->foreignId('comic_id')->constrained('comics')->cascadeOnDelete();
            $table->foreignId('superheroe_id')->constrained('superheroes')->cascadeOnDelete();
            $table->primary(['comic_id', 'superheroe_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comic_superheroe');
    }
};
