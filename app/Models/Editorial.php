<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    // sin esto Laravel pluraliza en inglés y buscaría la tabla 'editorials'
    protected $table = 'editoriales';

    protected $fillable = ['nombre'];

    public function comics()
    {
        return $this->hasMany(Comic::class);
    }
}
