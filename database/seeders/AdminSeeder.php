<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash; 

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Lojaen',
                'email' => 'lojaen@gmail.com',
                'password' => Hash::make('loj12345'),
            ],
            [
                'name' => 'Tasneem',
                'email' => 'tasneem@gmail.com',
                'password' => Hash::make('tas123'),
            ],
            [
                'name' => 'Rana',
                'email' => 'rana@gmail.com',
                'password' => Hash::make('ran456'),
            ],
            // complete admins here
        ];
    
        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
