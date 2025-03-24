<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Homepage route
Route::get('/', function () {
    return view('welcome');
});



