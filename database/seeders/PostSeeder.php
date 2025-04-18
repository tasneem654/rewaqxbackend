<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
  public function run()
  {
      // Add posts to the database
      Post::create([
          'id'=> 1,
          'user_id' => 1, // Replace with the ID of an existing user
          'content' => 'Just secured the MegaTech partnership! 🌟 This is a huge step forward for our team’s vision and growth goals. Proud of what we’ve accomplished together!',
          'image_path' => null,
          'created_at' => now()->subHours(2), // Post was created 2 hours ago
          
      ]);
  
      Post::create([
          'id'=> 2,
          'user_id' => 2, // Replace with the ID of an existing user
          'content' => 'We’re working on a new project — a smart task management system to make work life easier for everyone. Excited to see how this turns out! 🌟 Got ideas? Drop them my way! 😊',
          'image_path' => 'office.png',
          'created_at' => now()->subHours(3),
          'updated_at' => now()->subHours(3),
          
      ]);
  
      
  }
}