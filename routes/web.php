<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Homepage route
Route::get('/', function () {
    return view('welcome');
});

// Admin login routes
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');


// Admin dashboard route (protected by authentication)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware('auth');

Route::get('/admin/empManagement', function () {
    return view('admin.empManagement');
});


// Add additional routes for your application as needed, like:
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
