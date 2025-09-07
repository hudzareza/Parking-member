<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
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

Route::middleware(['auth', 'role:super-admin|pusat'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/pay', [InvoiceController::class, 'pay'])->name('invoices.pay');

    Route::resource('payments', PaymentController::class)->only(['index','show']);
});

// Callback Midtrans (POST)
Route::post('midtrans/notification', [PaymentController::class, 'notificationHandler']);

Route::get('branches/export/excel', [BranchController::class, 'exportExcel'])->name('branches.export.excel');
Route::get('branches/export/pdf', [BranchController::class, 'exportPdf'])->name('branches.export.pdf');

require __DIR__.'/auth.php';
