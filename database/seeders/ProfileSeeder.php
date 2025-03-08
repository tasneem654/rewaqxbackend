<?php
// database/seeders/ProfileSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;

class ProfileSeeder extends Seeder
{
    public function run()
    {
        // Get all users
        $users = User::all();

        // Create a profile for each user
        foreach ($users as $user) {
            Profile::create([
                'user_id' => $user->id,
                'name' => 'Tasneem Alhattami ' . $user->id, // Example name
                'role' => 'Software Enginner', // Example role
                'department' => 'IT Department', // Example department
                'dateOfBirth' => '2002-09-21', // Example date of birth
            ]);
        }
    }
}