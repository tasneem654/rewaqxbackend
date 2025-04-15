<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;

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


// عرض صفحة forgot password
Route::get('/admin/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');

// إرسال رابط لإيميل الأدمن
Route::post('/admin/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');

// عرض صفحة تعيين كلمة المرور الجديدة
Route::get('/admin/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');

// تنفيذ التحديث
Route::post('/admin/reset-password', [ResetPasswordController::class, 'reset'])->name('admin.password.update');
