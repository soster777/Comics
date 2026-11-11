<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    // sin esto Laravel pluraliza en inglés y buscaría la tabla 'autors'
    protected $table = 'autores';

    protected $fillable = ['nombre'];

    public function comics()
    {
        return $this->hasMany(Comic::class);
    }
}
