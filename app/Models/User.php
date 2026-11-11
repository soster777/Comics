<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// extiende Authenticatable (y no Model) para que Auth pueda loguearlo
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // is_admin NO va acá a propósito: así nadie se hace admin
    // agregando is_admin=1 al formulario de registro
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // nunca se muestran si el usuario se pasa a array o JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // así $user->is_admin devuelve true o false y no "1" o "0"
            'is_admin' => 'boolean',
        ];
    }

    // uno a muchos: un usuario puede mandar muchas consultas
    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
