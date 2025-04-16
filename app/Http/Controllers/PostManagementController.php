<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostManagementController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user.profile', 'reactions'])
           ->orderBy('created_at', 'desc')
           ->get()
           ->map(function ($post) {
               return [
                   'id' => $post->id,
                   'user_name' => optional($post->user->profile)->name ?? 'Unknown',
                   'content' => $post->content,
                   'image' => $post->image_path ? basename($post->image_path) : null,
                   'image_full' => $post->image_path ? Storage::url($post->image_path) : null,
                   'created_at' => $post->created_at->format('F j, Y'),
                   'reactions_count' => $post->reactions->count(),
               ];
           });

                   return view('admin.postsManagement', ['posts' => $posts]);
                  }

    public function deletePosts(Request $request)
    {
        $request->validate([
            'post_ids' => 'required|array',
            'post_ids.*' => 'exists:posts,id',
        ]);

        $posts = Post::whereIn('id', $request->post_ids)->get();

        foreach ($posts as $post) {
            if ($post->image_path) {
                Storage::delete($post->image_path);
            }
            $post->delete();
        }

        return redirect()->route('posts.management')->with('success', 'Post(s) deleted successfully.');
      }

}