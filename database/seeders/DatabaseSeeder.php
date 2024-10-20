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
        User::factory()->create([
            'name' => 'Johnny Bos',
            'email' => 'j.bos@rbosenzonen.nl',
            'is_admin' => true,
            'password' => bcrypt('Test1234!'),
        ]);

        User::factory()->create([
            'name' => 'Jesse Bos',
            'email' => 'jesse@rbosenzonen.nl',
            'is_admin' => true,
            'password' => bcrypt('Test1234!'),
        ]);

        User::factory()->create([
            'name' => 'Hidde Bos',
            'email' => 'h.bos@rbosenzonen.nl',
            'is_admin' => false,
            'password' => bcrypt('Test1234!'),
        ]);

        User::factory()->create([
            'name' => 'Theo Bos',
            'email' => 't.bos@rbosenzonen.nl',
            'is_admin' => false,
            'password' => bcrypt('Test1234!'),
        ]);
    }
}
