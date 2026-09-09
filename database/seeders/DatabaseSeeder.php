<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Data dummy sesuai kontrak Crew 3
        User::create([
            'name' => 'Admin Jara',
            'email' => 'admin@jara.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Budi (Owner)',
            'email' => 'budi@jara.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Siti (Member)',
            'email' => 'siti@jara.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}