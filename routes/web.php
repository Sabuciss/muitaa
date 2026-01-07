<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CasesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiclesController;
use App\Http\Middleware\EnsureRole;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('cases', CasesController::class);
Route::resource('vehicles', VehiclesController::class)->except(['show']);

// Example: protect admin-only routes (manage users) with the role middleware
// Usage: middleware accepts a pipe-separated list of roles, e.g. 'admin|inspector'

Route::middleware(['auth', EnsureRole::class.':admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{id}/toggle-active', [UserController::class, 'toggleActive'])->name('admin.users.toggle');
    Route::get('/admin/db/import', [\App\Http\Controllers\DashboardController::class, 'importDb'])->name('admin.db.import');
});

Route::middleware('auth')->group(function () {
    Route::get('/db/dump', [DashboardController::class, 'dumpDb'])->name('db.dump');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
