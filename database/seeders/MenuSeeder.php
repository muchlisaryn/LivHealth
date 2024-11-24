<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Menus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Salad Buah Sehat',
                'description' => 'Salad buah segar dengan campuran buah-buahan organik.',
                'price' => 45000, 
                'attachments' => 0, 
            ],
            [
                'name' => 'Ayam Panggang Lemon',
                'description' => 'Ayam panggang dengan bumbu lemon dan rempah alami.',
                'price' => 75000,
                'attachments' => 0,
            ],
            [
                'name' => 'Smoothie Bowl',
                'description' => 'Smoothie bowl dengan berbagai buah dan granola.',
                'price' => 60000,
                'attachments' => 0,
            ],
            [
                'name' => 'Nasi Merah dengan Sayuran',
                'description' => 'Nasi merah dengan berbagai sayuran sehat yang kaya serat.',
                'price' => 55000,
                'attachments' => 0,
            ],
            [
                'name' => 'Soup Ayam Sehat',
                'description' => 'Soup ayam dengan kaldu bening dan sayuran organik.',
                'price' => 65000,
                'attachments' => 0,
            ],
            [
                'name' => 'Salad Sayur dengan Tahu Tempe',
                'description' => 'Salad sayuran segar dengan tambahan tahu dan tempe.',
                'price' => 50000,
                'attachments' => 0,
            ],
            [
                'name' => 'Quinoa Bowl',
                'description' => 'Bowl quinoa dengan topping sayuran dan saus tahini.',
                'price' => 70000,
                'attachments' => 0,
            ],
            [
                'name' => 'Pasta Sehat dengan Pesto',
                'description' => 'Pasta gandum dengan saus pesto alami dari daun basil.',
                'price' => 85000,
                'attachments' => 0,
            ],
            [
                'name' => 'Grilled Salmon',
                'description' => 'Salmon panggang dengan bumbu rempah khas.',
                'price' => 95000,
                'attachments' => 0,
            ],
            [
                'name' => 'Muffin Protein',
                'description' => 'Muffin rendah gula dengan tambahan protein untuk energi.',
                'price' => 40000,
                'attachments' => 0,
            ],
        ];

        foreach ($menus as $menu) {
            $menu['category_id'] = Categories::inRandomORder()->first()->id;
            Menus::create($menu);
        }
    }
}
