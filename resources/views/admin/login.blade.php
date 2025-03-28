@extends('layouts.app')

@section('content')
<div class="login-container">
    <!-- Left Side Background -->
    <div class="login-background">
        <img src="{{ asset('images/logobackground.png') }}" alt="REWAQ X Background" class="background-img">
    </div>

    <!-- Right Side: Login Form -->
    <div class="login-form">
        <div class="form-box">
            <div class="logo-container">
                <img src="{{ asset('images/logo.svg') }}" alt="REWAQ X Logo" class="logo-img">
            </div>
            <h2 class="form-title">Login</h2>
            <p class="welcome-message">Welcome back</p>

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="forgot-password">
                    <a href="#">Forgot password?</a>
                </div>

                <button type="submit" class="login-button">Log In</button>
            </form>
        </div>
    </div>
</div>
<div class="bottom-line"></div>

@endsection

@section('styles')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection
