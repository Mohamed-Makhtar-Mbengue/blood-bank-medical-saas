<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmergencyController;

Route::get('/', function () {
    return redirect()->route('emergencies.index');
});

Route::prefix('emergencies')->name('emergencies.')->group(function () {
    Route::get('/', [EmergencyController::class, 'index'])->name('index');
    Route::get('/create', [EmergencyController::class, 'create'])->name('create');
    Route::post('/', [EmergencyController::class, 'store'])->name('store');
    Route::get('/{emergency}', [EmergencyController::class, 'show'])->name('show');
    Route::patch('/{emergency}/complete', [EmergencyController::class, 'complete'])->name('complete');
});
