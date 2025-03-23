<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        // Find the first post and user
        $post = Post::find(4); // Get the post with ID 1
        $user = User::find(1); // Get the user with ID 1

        // Ensure the post and user exist
        if ($post && $user) {
            // Add one comment to the first post
            Comment::create([
                'post_id' => $post->id, // Associate with post ID 1
                'user_id' => $user->id, // Associate with user ID 1
                'content' => 'This is a comment on the first post.',
            ]);
        } else {
            $this->command->info('Post or User not found. Please ensure the posts and users tables are seeded first.');
        }
    }
}