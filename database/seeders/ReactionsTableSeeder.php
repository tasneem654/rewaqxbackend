<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reaction;
use App\Models\User;
use App\Models\Post;

class ReactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Get some users and posts to associate with reactions
        $users = User::all();
        $posts = Post::all();

        // Define some reactions to seed
        $reactions = [
            ['emoji' => '❤️', 'points' => Reaction::getPointsForReaction('❤️')],
            ['emoji' => '👍', 'points' => Reaction::getPointsForReaction('👍')],
            ['emoji' => '👏', 'points' => Reaction::getPointsForReaction('👏')],
            ['emoji' => '😍', 'points' => Reaction::getPointsForReaction('😍')],
            ['emoji' => '🫡', 'points' => Reaction::getPointsForReaction('🫡')],
            ['emoji' => '🔥', 'points' => Reaction::getPointsForReaction('🔥')],
            ['emoji' => '🎁', 'points' => Reaction::getPointsForReaction('🎁')],
            ['emoji' => '💪', 'points' => Reaction::getPointsForReaction('💪')],
            ['emoji' => '🏆', 'points' => Reaction::getPointsForReaction('🏆')],
            ['emoji' => '🚀', 'points' => Reaction::getPointsForReaction('🚀')],
        ];

        // Seed reactions
        foreach ($reactions as $reactionData) {
            $user = $users->random();
            $post = $posts->random();

            Reaction::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'emoji' => $reactionData['emoji'],
                'points' => $reactionData['points'],
            ]);
        }
    }
}