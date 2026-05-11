<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
<<<<<<< HEAD
            'name' => 'Test User',
            'email' => 'test@example.com',
=======
            'name' => 'Yaza',
            'email' => 'yaza@test.com',
            'password' => bcrypt('1234'),
>>>>>>> 97a44a5c3bae4cdb3b49a6ecfd6bce9a80d74767
        ]);
    }
}
