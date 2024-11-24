<?php

namespace Database\Seeders;

use App\Models\Categories;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Reyhan',
            'email' => 'reyhan@livhealth.com',
            'password' => '123456',
            'role' => 'admin'
        ]);

        $this->call([
            CategorySeeder::class,
            MenuSeeder::class
        ]);
        
    }
}
