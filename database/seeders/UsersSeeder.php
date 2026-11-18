<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $admin = new User([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $admin->is_admin = true;
        $admin->save();

        User::create([
            'name' => 'Cliente',
            'email' => 'cliente@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
