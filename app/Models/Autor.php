<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autores';

    protected $fillable = ['nombre'];

    public function comics()
    {
        return $this->hasMany(Comic::class);
    }
}
