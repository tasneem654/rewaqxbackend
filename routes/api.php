<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\ReactionController;


// Route to fetch all posts (API endpoint)
Route::get('/posts', [PostController::class, 'index']);

// Route to fetch a specific post (API endpoint)
Route::get('/posts/{id}', [PostController::class, 'show']);

// Route to create a new post (API endpoint)
Route::post('/posts', [PostController::class, 'store']);

// Route to update a post (API endpoint)
Route::put('/posts/{id}', [PostController::class, 'update']);

// Route to delete a post (API endpoint)
Route::delete('/posts/{id}', [PostController::class, 'destroy']);


Route::post('posts/{postId}/comments', [CommentController::class, 'store']);
Route::post('posts/{postId}/reactions', [ReactionController::class, 'store']);