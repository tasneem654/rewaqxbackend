<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {

      $posts = Post::with('reactions', 'comments', 'user.profile')->get();

      \Log::info('Fetched posts:', ['posts' => $posts]);

      return response()->json($posts);
}

public function show(Request $request, $id)
{
    try {
        $post = Post::findOrFail($id);
        return response()->json(['data' => $post, 'headers' => $request->headers->all()]);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
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
            'user_id' => 1, // Replace with auth()->id() when authentication is enabled
            'content' => $request->content,
            'image_path' => $imagePath,
        ]);

        return response()->json($post, 201);
    }

    
}