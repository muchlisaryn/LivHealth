<?php

namespace Database\Seeders;

use App\Models\Menus;
use App\Models\Programs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $programs = [
            [
                'name' => 'Paket Diet Sehat',
                'description' => 'Program catering yang menyajikan makanan rendah kalori dan bergizi untuk mendukung program diet sehat.',
            ],
            [
                'name' => 'Paket Detoks',
                'description' => 'Program yang dirancang untuk membantu tubuh dalam proses detoksifikasi dengan makanan alami yang membantu membersihkan racun.',
            ],
            [
                'name' => 'Paket Makanan Seimbang',
                'description' => 'Program makanan sehat yang menawarkan gizi seimbang dengan karbohidrat, protein, dan lemak sehat dalam setiap porsi.',
            ],
            [
                'name' => 'Paket Bebas Gluten',
                'description' => 'Program catering yang menyajikan makanan bebas gluten untuk orang dengan intoleransi atau sensitivitas terhadap gluten.',
            ]
            ];
        
        $menuIds = Menus::pluck('id')->toArray();
        
        foreach($programs as $program) {
            if(!empty($menuIds)) {
                $program['menu_id'] =  $menuIds[array_rand($menuIds)];
                $program['price'] = rand(40000, 99999999);
                $program['duration_days'] = rand(3, 24);
            }

            Programs::create($program);
        }
    }
}
