<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaction;
use App\Models\Post;
use App\Models\User;
use App\Models\Points;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    public function store(Request $request, $postId)
    {
        // Validate the request
        $request->validate([
            'emoji' => 'required|string',
            'points' => 'required|integer|min:1', // Ensure points are positive
        ]);

        // Hardcode the authenticated user ID to 1 for testing
        $userId = 1; // Hardcoded user ID
        $user = User::find($userId); // Fetch the user with ID 1
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Find the post
        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        // Get the user's points record
        $userPoints = $user->points;
        if (!$userPoints) {
            return response()->json(['error' => 'User points record not found'], 404);
        }

        // Check if the user has enough points
        if ($userPoints->totalPoints < $request->points) {
            return response()->json(['error' => 'Not enough points'], 400);
        }

        // Deduct points from the user
        $userPoints->decrement('totalPoints', $request->points);

        // Add points to the post owner
        $postOwner = User::find($post->user_id);
        if ($postOwner) {
            $postOwnerPoints = $postOwner->points;
            if ($postOwnerPoints) {
                $postOwnerPoints->increment('totalPoints', $request->points);
            } else {
                return response()->json(['error' => 'Post owner points record not found'], 404);
            }
        }

        // Create the reaction
        $reaction = Reaction::create([
            'post_id' => $postId,
            'user_id' => $user->id, // Use the hardcoded user ID
            'emoji' => $request->emoji,
            'points' => $request->points,
        ]);

        return response()->json($reaction, 201);
    }
}