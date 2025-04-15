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

            <form method="POST" action="{{ route('admin.login.submit') }}" onsubmit="return validateForm()">
                @csrf

                @if($errors->any())
                    <div class="error-box">
                        <span class="error-icon">⚠️</span>
                        <span class="error-message">Email or password is incorrect.</span>
                    </div>
                @endif

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
                <a href="{{ route('admin.password.request') }}">Forgot password?</a>
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

@section('scripts')
<script>
    function validateForm() {
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        let valid = true;

        email.style.borderColor = '#ccc';
        password.style.borderColor = '#ccc';

        if (!email.value.includes('@') || email.value.length < 6) {
            email.style.borderColor = 'red';
            email.focus();
            valid = false;
        }

        if (password.value.length < 6) {
            password.style.borderColor = 'red';
            password.focus();
            valid = false;
        }

        return valid;
    }
</script>
@endsection
