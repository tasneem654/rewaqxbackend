<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaction;

class ReactionController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'emoji' => 'required|string',
            'points' => 'required|integer',
        ]);

        $reaction = Reaction::create([
            'post_id' => $postId,
            'emoji' => $request->emoji,
            'points' => $request->points,
        ]);

        return response()->json($reaction, 201);
    }
}