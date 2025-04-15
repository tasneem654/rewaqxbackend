@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-form">
        <div class="form-box">
            <div class="logo-container">
                <img src="{{ asset('images/logo.svg') }}" alt="REWAQ X Logo" class="logo-img">
            </div>

            <h2 class="form-title">Forgot Password</h2>
            <p class="welcome-message">Enter your email to reset your password</p>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" class="form-control" type="email" name="email" required autofocus>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="login-button">Send Recovery Link</button>
            </form>
        </div>
    </div>
</div>
<div class="bottom-line"></div>
@endsection
