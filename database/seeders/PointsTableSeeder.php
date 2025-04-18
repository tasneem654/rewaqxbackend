<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Points;
use Illuminate\Database\Seeder;

class PointsTableSeeder extends Seeder
{
    public function run()
    {
        // Clear existing points
        Points::truncate();
        
        // Get all users
        $users = User::all();
        
        // Define point values for each user (can customize per user)
        $pointValues = [
            'tawfiq1113@gmail.com' => 500,  // User 1
            'arwa8517@gmail.com' => 750,    // User 2
            'tasneem@gmail.com' => 1000      // User 3
        ];

        foreach ($users as $user) {
            Points::create([
                'user_id' => $user->id,
                'totalPoints' => $pointValues[$user->email] ?? 100, // Default 100 if email not found
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}