<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user?->hasRole('SUPERADMIN')) {
        return redirect()->route('superadmin.dashboard');
    }
    if ($user?->hasRole('ADMINISTRATEUR')) {
        return redirect()->route('admin.dashboard');
    }
    if ($user?->hasRole('ENSEIGNANT')) {
        return redirect()->route('teacher.dashboard');
    }
    if ($user?->hasRole('ETUDIANT')) {
        return redirect()->route('student.dashboard');
    }
    // Fallback
    return redirect()->route('profile.edit');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Role-based dashboards (targets for post-login redirects)
    Route::get('/student/dashboard', function () {
        return view('dashboards.student');
    })->middleware([\Spatie\Permission\Middleware\RoleMiddleware::class . ':ETUDIANT'])->name('student.dashboard');

    Route::get('/teacher/dashboard', function () {
        return view('dashboards.teacher');
    })->middleware([\Spatie\Permission\Middleware\RoleMiddleware::class . ':ENSEIGNANT'])->name('teacher.dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware([\Spatie\Permission\Middleware\RoleMiddleware::class . ':ADMINISTRATEUR'])
        ->name('admin.dashboard');

    Route::get('/superadmin/dashboard', [DashboardController::class, 'superadmin'])
        ->middleware([\Spatie\Permission\Middleware\RoleMiddleware::class . ':SUPERADMIN'])
        ->name('superadmin.dashboard');

    // Admin CRUD (SUPERADMIN only)
    Route::middleware([\Spatie\Permission\Middleware\RoleMiddleware::class . ':SUPERADMIN'])->group(function () {
        Route::resource('users', \App\Http\Controllers\UserController::class)->only(['index','show','create','store','edit','update','destroy']);
        Route::post('/users/{user}/activate', [\App\Http\Controllers\UserController::class, 'activate'])->name('users.activate');

        Route::resource('etudiants', \App\Http\Controllers\EtudiantController::class)
            ->only(['index','show','create','store','edit','update','destroy']);
        Route::post('/etudiants/{etudiant}/inscrire', [\App\Http\Controllers\EtudiantController::class, 'inscrire'])->name('etudiants.inscrire');

        Route::resource('enseignants', \App\Http\Controllers\EnseignantController::class)
            ->only(['index','show','create','store','edit','update','destroy']);

        Route::resource('inscriptions', \App\Http\Controllers\InscriptionController::class)
            ->only(['index','create','store']);

        Route::resource('filieres', \App\Http\Controllers\FiliereController::class);
        Route::resource('niveaux', \App\Http\Controllers\NiveauController::class);
        Route::resource('semestres', \App\Http\Controllers\SemestreController::class);
        Route::resource('salles', \App\Http\Controllers\SalleController::class);
        Route::resource('typeseances', \App\Http\Controllers\TypeSeanceController::class);
        Route::resource('classes', \App\Http\Controllers\ClasseController::class);
        Route::resource('cycles', \App\Http\Controllers\CycleController::class);

        Route::resource('roles', \App\Http\Controllers\RoleController::class);
        Route::resource('permissions', \App\Http\Controllers\PermissionController::class);

        // Academic Years
        Route::resource('academic-years', \App\Http\Controllers\AcademicYearController::class);

        Route::get('/parametres', [\App\Http\Controllers\ParametreController::class, 'parametreIndex'])->name('parametres.index');
    });
});

require __DIR__.'/auth.php';
