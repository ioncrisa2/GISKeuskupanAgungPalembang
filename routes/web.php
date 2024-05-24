<?php

use App\Http\Controllers\Admin\DekanatController;
use App\Http\Controllers\Admin\ParokiController;
use App\Http\Controllers\Admin\StasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->group(function(){
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::apiResource('dekanat',DekanatController::class)->except('show');
    Route::apiResource('paroki',ParokiController::class);
    Route::apiResource('stasi',StasiController::class);
})->middleware('auth');

require __DIR__.'/auth.php';
