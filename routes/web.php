<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\PostManagementController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EmployeeController;

// Homepage route
Route::get('/', function () {
    return view('welcome');
});

// Admin login routes
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');

// Routes for admin panel (protected by 'admin' middleware)
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware('App\Http\Middleware\RedirectIfNotAdmin')
    ->name('admin.dashboard');

// Admin routes for employee management
Route::get('/empManagement', function () {
    $employees = \App\Models\User::all();  // جلب كل الموظفين
    return view('admin.empManagement', compact('employees')); // تمرير المتغير إلى الـ View
});

// Route for storing new employee
Route::post('/empManagement', [EmployeeController::class, 'store'])->name('employees.store');

// Additional route for posts (controller method)
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Admin routes for posts management
Route::get('/postsManagement', [PostManagementController::class, 'index'])
     ->name('posts.management');
Route::post('/postsManagement/delete', [PostManagementController::class, 'deletePosts'])->name('admin.posts.delete');

// Route to display images from storage
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

// Forgot password routes
Route::get('/admin/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/admin/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');

// Reset password routes
Route::get('/admin/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');

// تنفيذ التحديث

Route::post('/admin/reset-password', [ResetPasswordController::class, 'reset'])->name('admin.password.update');


// Routes for employee management
Route::get('/empManagement', [EmployeeController::class, 'index'])->name('employees.index'); // عرض الموظفين
Route::get('/empManagement/create', [EmployeeController::class, 'create'])->name('employees.create'); // صفحة إضافة موظف
Route::post('/empManagement', [EmployeeController::class, 'store'])->name('employees.store'); // حفظ الموظف
Route::get('/empManagement/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit'); // صفحة تعديل موظف
Route::put('/empManagement/{id}', [EmployeeController::class, 'update'])->name('employees.update'); // تحديث الموظف
Route::delete('/empManagement/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy'); // حذف الموظف

//Router::post('/admin/reset-password', [ResetPasswordController::class, 'reset'])->name('admin.password.update');
Route::post('/admin/reset-password', [ResetPasswordController::class, 'reset'])->name('admin.password.update');

// Log out
Route::get('logout', function () {
    Auth::logout();
    return redirect('/admin/login');
})->name('logout');
