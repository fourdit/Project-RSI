<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ElectricityNoteController;

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Electricity Notes - CRUD Lengkap
    Route::get('/electricity-notes', [ElectricityNoteController::class, 'index'])->name('electricity-notes.index');
    Route::get('/electricity-notes/create', [ElectricityNoteController::class, 'create'])->name('electricity-notes.create');
    Route::post('/electricity-notes', [ElectricityNoteController::class, 'store'])->name('electricity-notes.store');
    Route::get('/electricity-notes/{id}/edit', [ElectricityNoteController::class, 'edit'])->name('electricity-notes.edit');
    Route::put('/electricity-notes/{id}', [ElectricityNoteController::class, 'update'])->name('electricity-notes.update');
    Route::delete('/electricity-notes/{id}', [ElectricityNoteController::class, 'destroy'])->name('electricity-notes.destroy');
    
    // Placeholder routes untuk fitur lain
    Route::get('/badge', function () {
        return view('placeholder', ['title' => 'Badge']);
    })->name('badge');
    
    Route::get('/calculator', function () {
        return view('placeholder', ['title' => 'Kalkulator Hemat Energi']);
    })->name('calculator');
    
    Route::get('/education', function () {
        return view('placeholder', ['title' => 'Edukasi']);
    })->name('education');
    
    Route::get('/discussion', function () {
        return view('placeholder', ['title' => 'Diskusi']);
    })->name('discussion');
    
    Route::get('/other-features', function () {
        return view('placeholder', ['title' => 'Fitur Lain']);
    })->name('other-features');
});