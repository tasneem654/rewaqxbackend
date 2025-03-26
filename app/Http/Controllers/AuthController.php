<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
// Show the login form
public function showLoginForm()
{
    return view('admin.login');
}

// Handle login form submission
public function login(Request $request)
{
    // Validate the input fields
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    // Attempt to log in the user
    if (Auth::attempt($validated)) {
        return redirect()->route('admin.dashboard'); // Redirect to the dashboard after login
    }

    // If login fails, redirect back with an error message
    return back()->withErrors(['email' => 'The provided credentials are incorrect.']);
}}
