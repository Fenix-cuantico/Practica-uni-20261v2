<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Administrador para pruebas
        User::create([
            'email' => 'patata@gmail.com',
            'password' => 'patata123', // Será hasheado por el cast 'hashed' en User.php
            'role' => 'admin',
            'status' => true,
        ]);

        $this->call([
            ScheduleSeeder::class,
            StudentSeeder::class,
        ]);
    }
}
