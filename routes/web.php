<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonneController;
use App\Http\Controllers\PasswordController;
use App\Http\Middleware\MustChangePassword;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// --- Routes publiques ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/personne', [PersonneController::class, 'showPersonneForm'])->name('personne');
Route::post('/personne', [PersonneController::class, 'personne'])->name('personne.submit');

// --- Routes accessibles si connecté (auth) ---
// Ici on met SEULEMENT les routes qui doivent être accessibles
// avant d’avoir changé le mot de passe
Route::middleware('auth')->group(function () {
    Route::get('/password/change', [PasswordController::class, 'showChangeForm'])->name('password.change.form');
    Route::post('/password/change', [PasswordController::class, 'changePassword'])->name('password.change.submit');
});

// --- Routes accessibles si connecté ET mot de passe changé ---
Route::middleware(['auth', MustChangePassword::class])->group(function () {
    // Dashboard (et toutes les autres pages internes)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // autres routes internes protégées :
    // Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    // Route::resource('/posts', PostController::class);
});
