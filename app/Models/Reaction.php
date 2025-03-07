<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    // Define predefined reactions and their associated points
    public const PREDEFINED_REACTIONS = [
        '❤️' => 0,
        '👍' => 10,
        '👏' => 20,
        '😍' => 30,
        '🫡' => 40,
        '🔥' => 50,
        '🎁' => 60,
        '💪' => 70,
        '🏆' => 80,
        '🚀' => 90,
    ];

    // Fillable fields
    protected $fillable = ['user_id', 'post_id', 'emoji', 'points'];

    // Define the relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship to Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Validate and get the points for a given reaction emoji.
     *
     * @param string $emoji
     * @return int|null
     */
    public static function getPointsForReaction(string $emoji): ?int
    {
        return self::PREDEFINED_REACTIONS[$emoji] ?? null;
    }

    /**
     * Check if a reaction is valid (exists in predefined reactions).
     *
     * @param string $emoji
     * @return bool
     */
    public static function isValidReaction(string $emoji): bool
    {
        return array_key_exists($emoji, self::PREDEFINED_REACTIONS);
    }
}