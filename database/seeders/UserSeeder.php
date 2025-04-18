<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing users and reset auto-increment
        User::truncate();
        
        $users = [
            [
                'email' => 'tawfiq1113@gmail.com',
                'password' => 'password123',
                'isManager' => false,
            ],
            [
                'email' => 'arwa8517@gmail.com',
                'password' => 'mysecurepassword', 
                'isManager' => false,
            ],
            [
                'email' => 'tasneem@gmail.com',
                'password' => 'mysecurepassword',
                'isManager' => false,
            ]
        ];

        foreach ($users as $userData) {
            User::create([
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'isManager' => $userData['isManager'],
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}