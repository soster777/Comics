<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // administrador de prueba
        $admin = new User([
            'name' => 'Admin',
            'email' => 'admin@comics.test',
            'password' => Hash::make('password123'),
        ]);
        // is_admin no está en $fillable, así que lo asigno a mano:
        // $fillable solo filtra la asignación masiva (create, fill, update con un array)
        $admin->is_admin = true;
        $admin->save();

        // cliente de prueba: el mismo rol que le toca a cualquiera que se registre
        User::create([
            'name' => 'Cliente',
            'email' => 'cliente@comics.test',
            'password' => Hash::make('password123'),
        ]);
    }
}
