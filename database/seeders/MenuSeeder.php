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
                'name' => 'Salad Sayuran Hijau dengan Biji Chia dan Alpukat',
                'description' => 'Kombinasi sayuran segar, biji chia, potongan alpukat, dan dressing berbahan dasar minyak zaitun dan lemon.',
                'category_id' => ['3'],
                'attachments' => 0, 
                
            ],
            [
                'name' => 'Sup Kacang Merah dengan Quinoa',
                'description' => 'Sup berbahan kacang merah, sayuran, dan quinoa yang kaya akan serat dan protein nabati.',
                'category_id' => ['3'],
                'attachments' => 0, 
            ],
            [
                'name' => 'Salmon Panggang dengan Brokoli dan Kentang Manis',
                'description' => 'almon yang dipanggang dengan bumbu herbal, disajikan dengan brokoli kukus dan kentang manis panggang.',
                'category_id' => ['4'],
                'attachments' => 0, 
            ],
            [
                'name' => 'Ayam Panggang dengan Salad Sayuran',
                'description' => 'Ayam tanpa kulit yang dipanggang, disajikan dengan salad sayuran segar dan dressing minyak zaitun.',
                'category_id' => ['4'],
                'attachments' => 0, 
            ],
            [
                'name' => 'Omelet Sayuran dengan Keju Feta',
                'description' => 'Omelet yang terbuat dari telur, sayuran (seperti bayam, paprika, dan tomat), dan taburan keju feta.',
                'category_id' => ['1','4'],
                'attachments' => 0, 
            ],
            [
                'name' => 'Ikan Bakar dengan Nasi Merah',
                'description' => 'Ikan bakar (seperti ikan tilapia atau kakap) disajikan dengan nasi merah dan sayuran kukus.',
                'category_id' => ['4'],
                'attachments' => 0,
            ],
            [
                'name' => 'Pizza Sayuran dengan Keju Mozzarella',
                'description' => 'Pizza berbahan dasar roti gandum, saus tomat, dan topping sayuran seperti zucchini, tomat, dan paprika, serta keju mozzarella.',
                'category_id' => ['2'],
                'attachments' => 0,
            ],
            [
                'name' => 'Pancake Gandum dengan Buah Segar',
                'description' => 'Pancake gandum utuh yang disajikan dengan topping buah-buahan segar (seperti pisang, berry, dan apel).',
                'category_id' => ['1'],
                'attachments' => 0,
            ],
            [
                'name' => 'Mie dengan Udang dan Sayuran',
                'description' => 'Mie gandum utuh yang disajikan dengan udang panggang dan sayuran segar seperti wortel, kol, dan timun.',
                'category_id' => ['2', '1'],
                'attachments' => 0,
            ],
            [
                'name' => 'Salad Tuna dengan Sayuran Segar',
                'description' => ' Tuna panggang (atau kalengan, tanpa minyak) yang dicampur dengan sayuran hijau, tomat, dan sedikit minyak zaitun.',
                'category_id' => ['2', '1'],
                'attachments' => 0,
            ],
        ];

        foreach ($menus as $menu) {
           
            Menus::create($menu);
        }
    }
}
