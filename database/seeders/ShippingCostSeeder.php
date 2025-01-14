<?php

namespace Database\Seeders;

use App\Models\ShippingCost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $city = [
            [
                'name' => 'Jakarta Pusat',
                'price' => 9000
            ],
            [
                'name' => 'Jakarta Selatan',
                'price' => 9000
            ],
            [
                'name' => 'Jakarta Utara',
                'price' => 9000
            ],
            [
                'name' => 'Jakarta Timur',
                'price' => 9000
            ],
        ];

        foreach($city as $data) {
            ShippingCost::create($data);
        }
    }
}
