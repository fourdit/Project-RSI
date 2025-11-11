@extends('layouts.auth')

@section('title', 'Login - ZENERGY')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <img src="{{ asset('images/logo-zenergy.png') }}" alt="ZENERGY">
        <span class="brand-name">ZENERGY</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-footer">
            <a href="{{ route('register') }}" class="link">Register</a>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
@endsection