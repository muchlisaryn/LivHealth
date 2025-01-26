<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Flexitarian', 'description' => 'Makan sebagian besar makanan berbasis tumbuhan, dengan sesekali produk hewani.'],
            ['name' => 'Vegetarian', 'description' => 'Menu tanpa daging untuk pola makan vegetarian.'],
            ['name' => 'Vegan', 'description' => 'Makanan berbasis tumbuhan tanpa produk hewani.'],
            ['name' => 'Non-Vegan', 'description' => 'Mengandung Produk Hewani.'],
        ];

        foreach ($categories as $category) {
            Categories::create($category);
        }
    }
}
