<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonneController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\MustChangePassword;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// --- Routes publiques ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes publiques d'inscription personne supprimées (plus utilisées)

// --- Routes accessibles si connecté (auth) ---
// Ici on met SEULEMENT les routes qui doivent être accessibles
// avant d’avoir changé le mot de passe
Route::middleware('auth')->group(function () {
    // Password as resource-like: edit/update
    Route::get('/password/change', [PasswordController::class, 'showChangeForm'])->name('password.edit');
    Route::put('/password/change', [PasswordController::class, 'changePassword'])->name('password.update');
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
        Route::resource('users', UserController::class)->only(['index','show','edit','update','destroy']);
        Route::post('/users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');

        // Personnes CRUD (admin)
        Route::resource('personnes', PersonneController::class)
            ->only(['index','create','store','show','edit','update','destroy']);

        // Étudiants CRUD + inscription
        Route::resource('etudiants', \App\Http\Controllers\EtudiantController::class)
            ->only(['index','show','edit','update','destroy']);
        Route::post('/etudiants/{etudiant}/inscrire', [\App\Http\Controllers\EtudiantController::class, 'inscrire'])->name('etudiants.inscrire');

        // Inscriptions scolaires (processus complet)
        Route::resource('inscriptions', \App\Http\Controllers\InscriptionController::class)
            ->only(['index','create','store']);

        // Filières & Années académiques
        Route::resource('filieres', \App\Http\Controllers\FiliereController::class);
        Route::resource('annees', \App\Http\Controllers\AnneeAcadController::class);

        // Niveaux & Semestres
        Route::resource('niveaux', \App\Http\Controllers\NiveauController::class);
        Route::resource('semestres', \App\Http\Controllers\SemestreController::class);

        // Salles, Types de séance, Classes, Cycles
        Route::resource('salles', \App\Http\Controllers\SalleController::class);
        Route::resource('typeseances', \App\Http\Controllers\TypeSeanceController::class);
        Route::resource('classes', \App\Http\Controllers\ClasseController::class);
        Route::resource('cycles', \App\Http\Controllers\CycleController::class);

        // Enseignants CRUD
        Route::resource('enseignants', \App\Http\Controllers\EnseignantController::class)
            ->only(['index','show','edit','update','destroy']);
        
        // Parametres
        Route::get('/parametres', [\App\Http\Controllers\ParametreController::class, 'parametreIndex'])->name('parametres.index');

    });

    // Fin des routes internes protégées
});
