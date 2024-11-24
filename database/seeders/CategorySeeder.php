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
            ['name' => 'Diet Rendah Kalori', 'description' => 'Makanan dengan kalori rendah untuk menjaga berat badan.'],
            ['name' => 'Diet Rendah Karbohidrat', 'description' => 'Menu rendah karbohidrat untuk pola makan keto atau low-carb.'],
            ['name' => 'Diet Tinggi Protein', 'description' => 'Pilihan makanan tinggi protein untuk pembentukan otot.'],
            ['name' => 'Vegetarian', 'description' => 'Menu tanpa daging untuk pola makan vegetarian.'],
            ['name' => 'Vegan', 'description' => 'Makanan berbasis tumbuhan tanpa produk hewani.'],
            ['name' => 'Makanan Bebas Gluten', 'description' => 'Menu bebas gluten untuk kebutuhan khusus.'],
            ['name' => 'Makanan Sehat Anak', 'description' => 'Pilihan makanan sehat yang cocok untuk anak-anak.'],
            ['name' => 'Makanan Lansia', 'description' => 'Menu khusus untuk mendukung kebutuhan nutrisi lansia.'],
            ['name' => 'Makanan Pasca Penyakit', 'description' => 'Menu untuk pemulihan setelah sakit.'],
            ['name' => 'Menu Seimbang Harian', 'description' => 'Pilihan makanan sehat dengan gizi seimbang untuk sehari-hari.'],
        ];

        foreach ($categories as $category) {
            Categories::create($category);
        }
    }
}
