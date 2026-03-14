<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\BloodInventoryController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonorController;

Route::get('/', function () {
    return redirect()->route('emergencies.index');
});

Route::resource('emergencies', EmergencyController::class)->only([
    'index', 'create', 'store', 'show', 'destroy'
]);

Route::patch('emergencies/{emergency}/complete', 
    [EmergencyController::class, 'complete']
)->name('emergencies.complete');

Route::resource('inventory', BloodInventoryController::class);

Route::resource('donations', DonationController::class);

Route::resource('donors', DonorController::class);
