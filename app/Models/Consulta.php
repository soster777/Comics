<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// cada mensaje que llega por el formulario de contacto
class Consulta extends Model
{
    protected $fillable = [
        'user_id',
        'nombre',
        'email',
        'mensaje',
    ];

    // la consulta pertenece a un usuario (puede ser null si la mandó un invitado)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
