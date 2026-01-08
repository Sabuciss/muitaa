<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\AnalystController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'welcome'])->name('home');
Route::get('/welcome', [DashboardController::class, 'welcome'])->name('welcome');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
});

// Broker Routes
Route::middleware(['auth', 'role:broker'])->group(function () {
    Route::get('/broker', [BrokerController::class, 'index'])->name('broker.index');
    Route::get('/broker/cases', [BrokerController::class, 'index'])->name('broker.cases');
    Route::get('/documents/create', [BrokerController::class, 'createDocument'])->name('documents.create');
    Route::post('/documents', [BrokerController::class, 'storeDocument'])->name('documents.store');
    Route::get('/documents/{id}/edit', [BrokerController::class, 'editDocument'])->name('documents.edit');
    Route::patch('/documents/{id}', [BrokerController::class, 'updateDocument'])->name('documents.update');
    Route::delete('/documents/{id}', [BrokerController::class, 'deleteDocument'])->name('documents.destroy');
    Route::post('/broker/document', [BrokerController::class, 'store'])->name('broker.document.store');
});

// Analyst Routes
Route::middleware(['auth', 'role:analyst'])->group(function () {
    Route::get('/analyst', [AnalystController::class, 'index'])->name('analyst.index');
    Route::get('/analyst/cases', [AnalystController::class, 'index'])->name('analyst.cases');
    Route::get('/analysis/create', [AnalystController::class, 'createAnalysis'])->name('analysis.create');
    Route::post('/analysis', [AnalystController::class, 'storeAnalysis'])->name('analysis.store');
    Route::get('/analysis/{id}/edit', [AnalystController::class, 'editAnalysis'])->name('analysis.edit');
    Route::patch('/analysis/{id}', [AnalystController::class, 'updateAnalysis'])->name('analysis.update');
    Route::delete('/analysis/{id}', [AnalystController::class, 'deleteAnalysis'])->name('analysis.delete');
    Route::post('/analyst/risk/all', [AnalystController::class, 'runAllRisk'])->name('analyst.risk.all');
    Route::post('/analyst/risk/{id}', [AnalystController::class, 'runRisk'])->name('analyst.risk');
});

// Inspector Routes
Route::middleware(['auth', 'role:inspector'])->group(function () {
    Route::get('/inspector', [InspectorController::class, 'index'])->name('inspector.index');
    Route::get('/inspector/case/{id}', [InspectorController::class, 'show'])->name('inspector.case');
    Route::get('/inspections/create', [InspectorController::class, 'createInspection'])->name('inspections.create');
    Route::post('/inspections', [InspectorController::class, 'storeInspection'])->name('inspections.store');
    Route::get('/inspections/{id}/edit', [InspectorController::class, 'editInspection'])->name('inspections.edit');
    Route::patch('/inspections/{id}', [InspectorController::class, 'updateInspection'])->name('inspections.update');
    Route::delete('/inspections/{id}', [InspectorController::class, 'deleteInspection'])->name('inspections.destroy');
    Route::post('/inspector/decision/{id}', [InspectorController::class, 'decision'])->name('inspector.decision');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
