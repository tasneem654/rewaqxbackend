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
          'user_id' => 1, // Replace with the ID of an existing user
          'content' => 'Just secured the MegaTech partnership! 🌟 This is a huge step forward for our team’s vision and growth goals. Proud of what we’ve accomplished together!',
          'reactions' => json_encode(['❤️' => 7, '👍' => 2, '🫡' => 4, '🏆' => 1, '🚀' => 1]),
          'comments' => 6,
          'image_path' => null,
          'created_at' => now()->subHours(2), // Post was created 2 hours ago
      ]);
  
      Post::create([
          'user_id' => 1, // Replace with the ID of an existing user
          'content' => 'We’re working on a new project — a smart task management system to make work life easier for everyone. Excited to see how this turns out! 🌟 Got ideas? Drop them my way! 😊',
          'reactions' => json_encode(['❤️' => 10, '😍' => 5, '🫡' => 5, '🔥' => 3]),
          'comments' => 10,
          'image_path' => 'images/office.png',
          'created_at' => now()->subHours(3), // Post was created 3 hours ago
      ]);
  
      Post::create([
          'user_id' => 1, // Replace with the ID of an existing user
          'content' => 'kjjjk',
          'reactions' => json_encode(['❤️' => 7, '👍' => 2, '🫡' => 4, '🏆' => 1, '🚀' => 1]),
          'comments' => 8,
          'image_path' => null,
          'created_at' => now()->subHours(5), // Post was created 5 hours ago
      ]);
  }
}