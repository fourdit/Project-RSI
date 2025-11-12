@extends('layouts.app')

@section('title', 'Profil - ZENERGY')

@section('content')
<div class="profile-container">
    <a href="{{ route('dashboard') }}" class="back-button">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </a>

    <div class="profile-card">
        <h1 class="profile-title">Profil</h1>
        
        <div class="profile-content">
            <div class="profile-left">
                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="profile-photo-large">
                <h2 class="profile-name">{{ Auth::user()->name }}</h2>
            </div>

            <div class="profile-right">
                <h2 class="biodata-title">Biodata</h2>
                
                <div class="biodata-grid">
                    <div class="biodata-item">
                        <span class="biodata-label">Nama</span>
                        <span class="biodata-value">{{ Auth::user()->name }}</span>
                    </div>

                    <div class="biodata-item">
                        <span class="biodata-label">Email</span>
                        <span class="biodata-value">{{ Auth::user()->email }}</span>
                    </div>

                    <div class="biodata-item">
                        <span class="biodata-label">Domisili</span>
                        <span class="biodata-value">{{ Auth::user()->domisili ?? '-' }}</span>
                    </div>
                </div>

                <button onclick="window.location.href='{{ route('profile.edit') }}'" class="btn btn-primary">
                    Edit profile
                </button>
            </div>
        </div>
    </div>
</div>
@endsection