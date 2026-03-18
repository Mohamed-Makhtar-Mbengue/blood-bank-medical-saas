<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/test-session', function () {
    session(['mohamed' => 'ok']);
    return 'session set';
});

Route::get('/test-session-read', function () {
    return session('mohamed', 'not found');
});

    // Modules SaaS
    Route::resource('donors', DonorController::class);
    Route::resource('donations', DonationController::class);
    Route::resource('inventory', InventoryController::class);
    Route::resource('emergencies', EmergencyController::class);
});


require __DIR__.'/auth.php';
