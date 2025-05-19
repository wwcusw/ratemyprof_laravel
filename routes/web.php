<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TwoFactorAuthController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Middleware\Ensure2FAIsVerified; 

// ✅ Force register 2fa middleware at runtime
app('router')->aliasMiddleware('2fa', Ensure2FAIsVerified::class);

// =======================
// Core Redirect Logic
// =======================

Route::get('/', function () {
    return Auth::check() ? redirect('/redirect-user') : redirect('/login');
});

Route::get('/redirect-user', function () {
    $role = Auth::user()->role;
    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'faculty' => redirect()->route('faculty.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        default => abort(403),
    };
})->middleware('auth');


// =======================
// 2FA FLOW SEGMENT
// =======================

// Step 1: OTP prompt after login
Route::get('/2fa', [TwoFactorAuthController::class, 'show2FAForm'])->name('2fa.form');
Route::post('/2fa/verify', [TwoFactorAuthController::class, 'verify2FA'])->name('2fa.verify');

// Step 2: Setup 2FA (QR + secret + OTP entry)
Route::middleware(['auth'])->group(function () {
    Route::get('/2fa/setup', [TwoFactorController::class, 'showSetupForm'])->name('2fa.setup');
    Route::post('/2fa/enable', [TwoFactorController::class, 'enable2FA'])->name('2fa.enable');
    Route::get('/2fa/confirm', [TwoFactorController::class, 'showVerifyForm'])->name('2fa.verify.confirm');
    Route::post('/2fa/confirm', [TwoFactorController::class, 'verify2FA'])->name('2fa.verify.post');
});


// =======================
// Protected Routes (auth + 2fa)
// =======================
Route::middleware(['auth', '2fa'])->group(function () {

    // Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
        Route::get('/admin/evaluations', [AdminController::class, 'showEvaluations'])->name('admin.evaluations');
        Route::post('/admin/toggle-results', [AdminController::class, 'toggleResults'])->name('admin.toggleResults');
        Route::post('/admin/set-semester', [AdminController::class, 'setSemester'])->name('admin.setSemester');
        Route::post('/admin/create-account', [AdminController::class, 'createAccount'])->name('admin.createAccount');
        Route::get('/admin/accounts', fn() => view('admin.accounts'))->name('admin.accounts');
        Route::put('/admin/accounts/{id}', [AdminController::class, 'updateAccount'])->name('admin.updateAccount');
        Route::delete('/admin/accounts/{id}', [AdminController::class, 'deleteAccount'])->name('admin.deleteAccount');
    });

    // Faculty
    Route::middleware('role:faculty')->group(function () {
        Route::get('/faculty/dashboard', fn() => view('faculty.facultydashboard'))->name('faculty.dashboard');
        Route::get('/faculty/results', [FacultyController::class, 'showResults'])->name('faculty.results');
    });

    // Student
    Route::middleware(['verified', 'role:student'])->group(function () {
        Route::get('/dashboard', fn() => view('student.dashboard'))->name('student.dashboard');
        Route::get('/student/evaluate', [EvaluationController::class, 'showForm'])->name('evaluation.form');
        Route::post('/student/evaluate', [EvaluationController::class, 'store'])->name('evaluation.submit');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth scaffolding (login, registration, password reset, etc.)
require __DIR__ . '/auth.php';
