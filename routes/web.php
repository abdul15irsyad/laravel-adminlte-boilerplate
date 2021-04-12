<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// no middleware
Route::get('/verify-email-process', [AuthController::class, 'verify_email_process'])->name('verify.email.process');

// not authenticated
Route::group(['middleware' => 'guest'], function () {
    Route::get('/',function(){
        return redirect()->route('login');
    });
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'login_process'])->name('login');
    Route::get('/forgot-password', [AuthController::class, 'forgot_password'])->name('forgot.password');
    Route::post('/forgot-password-process', [AuthController::class, 'forgot_password_process'])->name('forgot.password.process');
    Route::get('/reset-password', [AuthController::class, 'reset_password'])->name('reset.password');
    Route::post('/reset-password-process', [AuthController::class, 'reset_password_process'])->name('reset.password.process');
});

// authenticated
Route::group(['middleware' => 'auth'], function () {
    Route::get('/',function(){
        return redirect()->route('dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
