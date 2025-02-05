<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Reyhan',
                'email' => 'reyhan@livhealth.com',
                'password' => '123456',
                'address' => "Jl Kemang I 4 B, Dki Jakarta",
                'role' => 'admin'
            ],
            [
                'name' => 'Adit',
                'email' => 'admin@livhealth.com',
                'password' => '123456',
                'address' => "Jl HR Rasuna Said Kav H 1-2 Puri Matari, Dki Jakarta",
                'role' => 'admin'
            ],
            [
                'name' => 'Tina',
                'email' => 'owner@livhealth.com',
                'password' => '123456',
                'address' => "Jl HR Rasuna Said Kav H 1-2 Puri Matari, Dki Jakarta",
                'role' => 'owner'
            ],
            [
                'name' => 'Darko',
                'email' => 'finance@livhealth.com',
                'password' => '123456',
                'address' => "Jl HR Rasuna Said Kav H 1-2 Puri Matari, Dki Jakarta",
                'role' => 'finance'
            ],
            [
                'name' => 'Budi',
                'email' => 'kurir@livhealth.com',
                'password' => '123456',
                'address' => "Jl HR Rasuna Said Kav H 1-2 Puri Matari, Dki Jakarta",
                'role' => 'kurir'
            ],
            [
                'name' => 'Indra',
                'email' => 'ahli-gizi@livhealth.com',
                'password' => '123456',
                'address' => "Jl HR Rasuna Said Kav H 1-2 Puri Matari, Dki Jakarta",
                'role' => 'ahli gizi'
            ],
            [
                'name' => 'Agung',
                'email' => 'customer@livhealth.com',
                'password' => '123456',
                'address' => "Jl Pluit Raya 32 AC, Dki Jakarta",
                'role' => 'customer'
            ],
        ];

        foreach($users as $user){
            User::factory()->create($user);
        }
    }
}
