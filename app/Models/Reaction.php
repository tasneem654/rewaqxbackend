<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $primaryKey = null; 

    public $fillable = ['post_id', 'user_id', 'emoji', 'points'];

    public static function getPointsForReaction(string $emoji): int
    {
        // Define the point value for each emoji
        $pointsMap = [
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

        return $pointsMap[$emoji] ?? 1; // default to 1 if emoji not found
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}