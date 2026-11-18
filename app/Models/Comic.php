<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function superheroes()
    {
        return $this->belongsToMany(Superheroe::class, 'comic_superheroe', 'comic_id', 'superheroe_id');
    }

    public function editorial()
    {
        return $this->belongsTo(Editorial::class);
    }

    public function getPortadaUrlAttribute(): ?string
    {
        return $this->portada ? asset('storage/'.$this->portada) : null;
    }
}
