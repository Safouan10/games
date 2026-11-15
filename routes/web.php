<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

// Startpagina
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Game-overzicht: iedereen mag dit bekijken
Route::get('/games', [GameController::class, 'index']);

// Alleen admins mogen games beheren en bekijken
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Game Collection
    Route::get('/games/create', [GameController::class, 'create']);
    Route::post('/games/store', [GameController::class, 'store']);
    Route::get('/games/show/{id}', [GameController::class, 'show']);
    Route::get('/games/edit/{id}', [GameController::class, 'edit']);
    Route::post('/games/update/{id}', [GameController::class, 'update']);
    Route::post('/games/destroy/{id}', [GameController::class, 'destroy']);

    // Permissies beheren
    Route::prefix('beheer')->name('admin.')->group(function () {
        Route::get('/permissies', [PermissionController::class, 'index'])
            ->name('permissions.index');

        Route::get('/permissies/create', [PermissionController::class, 'create'])
            ->name('permissions.create');

        Route::post('/permissies', [PermissionController::class, 'store'])
            ->name('permissions.store');

        Route::get('/permissies/{permission}/edit', [PermissionController::class, 'edit'])
            ->name('permissions.edit');

        Route::put('/permissies/{permission}', [PermissionController::class, 'update'])
            ->name('permissions.update');

        Route::delete('/permissies/{permission}', [PermissionController::class, 'destroy'])
            ->name('permissions.destroy');
    });
});

// Profiel en geheime pagina: ingelogde gebruikers
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/geheim', function () {
        return view('geheim');
    });
});

require __DIR__.'/auth.php';