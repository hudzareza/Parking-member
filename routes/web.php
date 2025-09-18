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
use App\Http\Controllers\SelfServiceController;
use App\Http\Controllers\PortalMemberController;

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
    Route::get('invoices/pending-proofs', [InvoiceController::class, 'pendingProofs'])
        ->name('admin.invoices.pending');

    Route::get('invoices/{invoice}/pay', [InvoiceController::class, 'pay'])
        ->name('invoices.pay');

    Route::resource('invoices', InvoiceController::class);

    Route::post('invoices/{invoice}/verify', [InvoiceController::class, 'verifyProof'])->name('admin.invoices.verify');
    Route::post('invoices/{invoice}/reject', [InvoiceController::class, 'rejectProof'])->name('admin.invoices.reject');

    Route::resource('payments', PaymentController::class)->only(['index','show']);
});


Route::middleware(['auth', 'role:super-admin|pusat'])->group(function () {
    Route::get('vehicles/list-per-branch', [VehicleController::class, 'listPerBranch'])->name('vehicles.listPerBranch');
    Route::get('vehicles/export/excel', [VehicleController::class, 'exportExcel'])->name('vehicles.export.excel');
    Route::get('vehicles/export/pdf', [VehicleController::class, 'exportPdf'])->name('vehicles.export.pdf');
});


// Callback Midtrans (POST)
Route::post('midtrans/notification', [PaymentController::class, 'notificationHandler']);

Route::get('branches/export/excel', [BranchController::class, 'exportExcel'])->name('branches.export.excel');
Route::get('branches/export/pdf', [BranchController::class, 'exportPdf'])->name('branches.export.pdf');

Route::get('users/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');
Route::get('users/export/pdf', [UserController::class, 'exportPdf'])->name('users.export.pdf');

Route::get('members/export/excel', [MemberController::class, 'exportExcel'])->name('members.export.excel');
Route::get('members/export/pdf', [MemberController::class, 'exportPdf'])->name('members.export.pdf');

Route::get('tariffs/export/excel', [TariffController::class, 'exportExcel'])->name('tariffs.export.excel');
Route::get('tariffs/export/pdf', [TariffController::class, 'exportPdf'])->name('tariffs.export.pdf');

Route::get('payments/export/excel', [PaymentController::class, 'exportExcel'])->name('payments.export.excel');
Route::get('payments/export/pdf', [PaymentController::class, 'exportPdf'])->name('payments.export.pdf');

// Pendaftaran Member (self service, tanpa login)
Route::get('self-service/register', [SelfServiceController::class, 'showForm'])->name('portal.form');
Route::post('self-service/register', [SelfServiceController::class, 'submit'])->name('portal.register.process');
Route::post('self-service/perpanjang', [SelfServiceController::class, 'processRenew'])->name('portal.renew.process');

// Portal Member (akses via token unik, tanpa login)
Route::get('portal/{token}', [PortalMemberController::class, 'show'])->name('portal.member');

Route::post('portal/invoices/{invoice}/proof', [PortalMemberController::class, 'uploadProof'])
    ->name('portal.invoices.uploadProof');


require __DIR__.'/auth.php';
