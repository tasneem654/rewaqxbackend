<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaction;
use App\Models\Post;

class ReactionController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'emoji' => 'required|string',
            'points' => 'required|integer',
        ]);

        // Check if the reaction already exists for the post and user
        $existingReaction = Reaction::where('post_id', $postId)
            ->where('emoji', $request->emoji)
            ->first();

        if ($existingReaction) {
            // If the reaction exists, increment the points
            $existingReaction->increment('points', $request->points);
            return response()->json($existingReaction, 200);
        } else {
            // If the reaction does not exist, create a new one
            $reaction = Reaction::create([
                'post_id' => $postId,
                'emoji' => $request->emoji,
                'points' => $request->points,
            ]);

            return response()->json($reaction, 201);
        }
    }
}