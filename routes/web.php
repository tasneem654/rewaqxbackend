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


<<<<<<< HEAD
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

=======
// عرض صفحة forgot password
Route::get('/admin/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');

// إرسال رابط لإيميل الأدمن
Route::post('/admin/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');

// عرض صفحة تعيين كلمة المرور الجديدة
Route::get('/admin/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');

// تنفيذ التحديث
Route::post('/admin/reset-password', [ResetPasswordController::class, 'reset'])->name('admin.password.update');
>>>>>>> fdc74b6cf34bc9de537e1d78778faff48b2e4c2d
