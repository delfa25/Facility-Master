<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonneController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailTestController;
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
        $counts = [
            'personnes' => \App\Models\Personne::count(),
            'etudiants' => \App\Models\Etudiant::count(),
            'enseignants' => \App\Models\Enseignant::count(),
        ];
        return view('dashboard', compact('counts'));
    })->name('dashboard');

    // --- Routes admin uniquement ---
    Route::middleware([\App\Http\Middleware\RoleMiddleware::class . ':ADMINISTRATEUR'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Personnes CRUD (admin)
        Route::get('/personnes', [PersonneController::class, 'index'])->name('personnes.index');
        Route::get('/personnes/{personne}', [PersonneController::class, 'show'])->name('personnes.show');
        Route::get('/personnes/{personne}/edit', [PersonneController::class, 'edit'])->name('personnes.edit');
        Route::put('/personnes/{personne}', [PersonneController::class, 'update'])->name('personnes.update');
        Route::delete('/personnes/{personne}', [PersonneController::class, 'destroy'])->name('personnes.destroy');

        // Étudiants CRUD + inscription
        Route::get('/etudiants', [\App\Http\Controllers\EtudiantController::class, 'index'])->name('etudiants.index');
        Route::get('/etudiants/{etudiant}', [\App\Http\Controllers\EtudiantController::class, 'show'])->name('etudiants.show');
        Route::get('/etudiants/{etudiant}/edit', [\App\Http\Controllers\EtudiantController::class, 'edit'])->name('etudiants.edit');
        Route::put('/etudiants/{etudiant}', [\App\Http\Controllers\EtudiantController::class, 'update'])->name('etudiants.update');
        Route::post('/etudiants/{etudiant}/inscrire', [\App\Http\Controllers\EtudiantController::class, 'inscrire'])->name('etudiants.inscrire');
        Route::delete('/etudiants/{etudiant}', [\App\Http\Controllers\EtudiantController::class, 'destroy'])->name('etudiants.destroy');

        // Enseignants CRUD
        Route::get('/enseignants', [\App\Http\Controllers\EnseignantController::class, 'index'])->name('enseignants.index');
        Route::get('/enseignants/{enseignant}', [\App\Http\Controllers\EnseignantController::class, 'show'])->name('enseignants.show');
        Route::get('/enseignants/{enseignant}/edit', [\App\Http\Controllers\EnseignantController::class, 'edit'])->name('enseignants.edit');
        Route::put('/enseignants/{enseignant}', [\App\Http\Controllers\EnseignantController::class, 'update'])->name('enseignants.update');
        Route::delete('/enseignants/{enseignant}', [\App\Http\Controllers\EnseignantController::class, 'destroy'])->name('enseignants.destroy');
    });

    // Temporary route to test SMTP configuration (secured behind auth)
    Route::get('/mail/test', [MailTestController::class, 'sendTest'])->name('mail.test');
    // autres routes internes protégées :
    // Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    // Route::resource('/posts', PostController::class);
});
