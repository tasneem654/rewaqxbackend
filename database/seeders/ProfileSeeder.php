<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run()
    {
        // Clear existing profiles
        Profile::truncate();
        
        $users = User::all();
        $profiles = [
            [
                'name' => 'Arwa Tawfiq',
                'role' => 'Software Engineer',
                'department' => 'IT Department',
                'dateOfBirth' => '2001-05-03',
                'image' => 'profile_images/avatar.png'
            ],
            [
                'name' => 'Roaa Alhattami',
                'role' => 'Network Engineer',
                'department' => 'IT Department',
                'dateOfBirth' => '2003-09-20',
                'image' => 'profile_images/avatar.png'
            ],
            [
                'name' => 'Tasneem Alhattami',
                'role' => 'Software Engineer',
                'department' => 'IT Department',
                'dateOfBirth' => '2002-09-21',
                'image' => 'profile_images/avatar.png'
            ]
        ];

        foreach ($users as $index => $user) {
            Profile::create([
                'user_id' => $user->id,
                ...$profiles[$index] // Spread operator for profile data
            ]);
        }
    }
}