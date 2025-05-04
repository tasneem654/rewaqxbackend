<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\PostManagementController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EmployeeController;

// Homepage route
Route::get('/', function () {
    return view('welcome');
});

// Admin login routes 
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');

// Admin Dashboard (protected)
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware('App\Http\Middleware\RedirectIfNotAdmin')
    ->name('admin.dashboard');

// Posts Management (protected)
Route::get('/postsManagement', [PostManagementController::class, 'index'])
    ->middleware('App\Http\Middleware\RedirectIfNotAdmin')
    ->name('posts.management');

Route::post('/postsManagement/delete', [PostManagementController::class, 'deletePosts'])
    ->middleware('App\Http\Middleware\RedirectIfNotAdmin')
    ->name('admin.posts.delete');

// Posts display (protected)
Route::get('/posts', [PostController::class, 'index'])
    ->middleware('App\Http\Middleware\RedirectIfNotAdmin')
    ->name('posts.index');

// Images display 
Route::get('/images/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);

    if (!file_exists($filePath)) {
        abort(404);
    }

    return response()->file($filePath, [
        'Content-Type' => mime_content_type($filePath),
        'Access-Control-Allow-Origin' => '*'
    ]);
})->where('path', '.*');

// Forgot password routes 
Route::get('/admin/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/admin/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');

// Reset password routes 
Route::get('/admin/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');

// تنفيذ التحديث
Route::post('/admin/reset-password', [ResetPasswordController::class, 'reset'])->name('admin.password.update');
