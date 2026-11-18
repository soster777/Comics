<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Superheroe extends Model
{
    protected $fillable = ['nombre'];

    public function comics()
    {
        return $this->belongsToMany(Comic::class, 'comic_superheroe', 'superheroe_id', 'comic_id');
    }
}
