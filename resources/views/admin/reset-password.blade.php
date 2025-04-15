@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-form">
        <div class="form-box">
            <div class="logo-container">
                <img src="{{ asset('images/logo.svg') }}" alt="REWAQ X Logo" class="logo-img">
            </div>
            <h2 class="form-title">Reset Password</h2>

            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input id="password" type="password" name="password" class="form-control" required>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="login-button">Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection
