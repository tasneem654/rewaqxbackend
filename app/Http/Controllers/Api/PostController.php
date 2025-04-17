<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('reactions', 'comments', 'user.profile')->get()
            ->map(function ($post) {
                // Convert image path to URL using same method as profile
                if ($post->image_path) {
                    $post->image_path = url('/images/' . $post->image_path);
                }

                 // Convert user profile image to URL
                if ($post->user->profile->image) {
                  $post->user->image = url('/images/' . $post->user->profile->image);
              }
                return $post;
            });

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $post = Post::create([
            'user_id' => 1,
            'content' => $request->content,
            'image_path' => $imagePath, // stores as "images/filename.jpg"
        ]);

        // Return with full URL like profile endpoint
        $post->image_path = $post->image_path ? url('/images/' . $post->image_path) : null;
        
        return response()->json($post, 201);
    }
}