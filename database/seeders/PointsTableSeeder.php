<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Points;
use Illuminate\Database\Seeder;

class PointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Assign 100 points to each user
        $users = User::all();
        foreach ($users as $user) {
            Points::create([
                'user_id' => $user->id,
                'totalPoints' => 100,
            ]);
        }
    }
}
