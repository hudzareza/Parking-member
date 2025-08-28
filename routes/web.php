<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'permission:manage branches'])->group(function () {
    Route::resource('branches', BranchController::class);
});

Route::middleware(['auth', 'permission:manage members'])->group(function () {
    Route::resource('members', MemberController::class);
});

Route::middleware(['auth', 'permission:manage members'])->group(function () {
    Route::resource('members.vehicles', VehicleController::class);
});

Route::middleware(['auth', 'permission:manage tariffs'])->group(function () {
    Route::resource('tariffs', TariffController::class);
});

require __DIR__.'/auth.php';
