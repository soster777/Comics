<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Comic extends Model
{
    protected $fillable = [
        'comic',
        'sinopsis',
        'precio',
        'portada',
        'autor_id',
        'editorial_id',
    ];

    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    // muchos a muchos: un cómic puede tener varios superhéroes (un crossover)
    // y un superhéroe aparece en muchos cómics. La relación vive en la tabla comic_superheroe
    public function superheroes()
    {
        return $this->belongsToMany(Superheroe::class, 'comic_superheroe', 'comic_id', 'superheroe_id');
    }

    public function editorial()
    {
        return $this->belongsTo(Editorial::class);
    }

    // accessor: permite escribir $comic->portada_url en las vistas.
    // arma la URL pública (/storage/portadas/...) a partir del path guardado en la columna portada
    public function getPortadaUrlAttribute(): ?string
    {
        return $this->portada ? Storage::disk('public')->url($this->portada) : null;
    }
}
