@extends('layouts.app')

@section('title', 'Edit Profil - ZENERGY')

@section('content')
<div class="profile-edit-overlay">
    <div class="profile-edit-modal">
        <a href="{{ route('profile.show') }}" class="modal-close-btn">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>

        <div class="profile-edit-content">
            <div class="profile-photo-section">
                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="profile-photo-edit" id="preview-photo">
                <label for="profile_photo" class="change-photo-label">Ganti Foto Profil</label>
            </div>

            <h2 class="modal-title">Biodata</h2>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-form">
                @csrf
                @method('PUT')

                <input type="file" id="profile_photo" name="profile_photo" accept="image/*" style="display: none;" onchange="previewImage(event)">

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="domisili">Domisili</label>
                    <input type="text" id="domisili" name="domisili" value="{{ old('domisili', Auth::user()->domisili) }}" placeholder="Masukkan kota domisili">
                    @error('domisili')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="{{ Auth::user()->email }}" readonly>
                    <small class="input-note">Email tidak dapat diubah</small>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('preview-photo');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection