<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; // Add this line
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('reactions', 'comments')->get();
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
            'user_id' => 1, // Replace with auth()->id() when authentication is enabled
            'content' => $request->content,
            'image_path' => $imagePath,
        ]);

        return response()->json($post, 201);
    }


    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        Storage::disk('public')->delete($post->image_path); // Delete the associated image
        $post->delete();
        return response()->json(null, 204);
    }
}
