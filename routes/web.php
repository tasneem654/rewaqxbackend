<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

// Homepage route
Route::get('/', function () {
    return view('welcome');
});

// Admin login routes
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');

// Routes for admin panel (protected by 'admin' middleware)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('App\Http\Middleware\RedirectIfNotAdmin')->name('admin.dashboard');

// Admin routes for employee management
Route::get('/empManagement', function () {
    return view('admin.empManagement');
});

// Admin routes for posts management
Route::get('/postsManagement', function () {
    return view('admin.postsManagement');  // This assumes the file is in resources/views/admin
});

// Additional route for posts (controller method)
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');


Route::get('/images/{path}', function ($path) {
  // The full path now comes from the URL parameter
  $filePath = storage_path('app/public/' . $path);
  
  if (!file_exists($filePath)) {
      abort(404);
  }

  return response()->file($filePath, [
      'Content-Type' => mime_content_type($filePath),
      'Access-Control-Allow-Origin' => '*'
  ]);
})->where('path', '.*');

