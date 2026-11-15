
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Route;

// Startpagina
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Game-overzicht
Route::get('/games', [GameController::class, 'index']);

// Alleen admins mogen beheerpagina's openen
Route::middleware(['auth', 'role:admin'])
    ->prefix('beheer')
    ->name('admin.')
    ->group(function () {

        // Permissies beheren
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

        // Rollen beheren
        Route::get('/rollen', [RoleController::class, 'index'])
            ->name('roles.index');
        Route::get('/rollen/create', [RoleController::class, 'create'])
            ->name('roles.create');
        Route::post('/rollen', [RoleController::class, 'store'])
            ->name('roles.store');
        Route::get('/rollen/{role}/edit', [RoleController::class, 'edit'])
            ->name('roles.edit');
        Route::put('/rollen/{role}', [RoleController::class, 'update'])
            ->name('roles.update');
        Route::delete('/rollen/{role}', [RoleController::class, 'destroy'])
            ->name('roles.destroy');

        // Permissies aan rollen koppelen
        Route::get('/rol-permissies', [RolePermissionController::class, 'index'])
            ->name('role-permissions.index');
        Route::post('/rol-permissies', [RolePermissionController::class, 'store'])
            ->name('role-permissions.store');
        Route::delete('/rol-permissies/{role}/{permission}', [RolePermissionController::class, 'destroy'])
            ->name('role-permissions.destroy');
    });

// Profiel en geheime pagina: ingelogde gebruikers
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/geheim', function () {
        return view('geheim');
    });
});

require __DIR__.'/auth.php';
