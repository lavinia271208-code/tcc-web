<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // adm
        User::create([
            'name' => 'Lavinia Alves',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
        ]);

        // cliente
        User::create([
            'name' => 'Liz',
            'email' => 'cliente@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => false,
        ]);
    }
}
