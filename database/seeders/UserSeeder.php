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
    
                'role' => 'admin'
            ],
            [
                'name' => 'Adit',
                'email' => 'admin@livhealth.com',
                'password' => '123456',
    
                'role' => 'admin'
            ],
            [
                'name' => 'Hendra',
                'email' => 'owner@livhealth.com',
                'password' => '123456',
                
                'role' => 'owner'
            ],
            [
                'name' => 'Darko',
                'email' => 'finance@livhealth.com',
                'password' => '123456',
               
                'role' => 'finance'
            ],
            [
                'name' => 'Budi',
                'email' => 'kurir@livhealth.com',
                'password' => '123456',
               
                'role' => 'kurir'
            ],
            [
                'name' => 'Indra',
                'email' => 'customer@livhealth.com',
                'password' => '123456',
               
                'role' => 'customer'
            ],
            [
                'name' => 'Agung',
                'email' => 'agung@livhealth.com',
                'password' => '123456',
    
                'role' => 'customer'
            ],
        ];

        foreach($users as $user){
            User::factory()->create($user);
        }
    }
}
