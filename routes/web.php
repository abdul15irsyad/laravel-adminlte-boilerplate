<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionRoleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

// no middleware
Route::prefix('{locale}')->group(function(){
    Route::get('/verify-email-process', [AuthController::class, 'verify_email_process'])->name('verify.email.process');
});

// not authenticated
Route::middleware(['guest'])->group(function () {
    Route::get('/',function(){
        return redirect()->route('login',['locale'=>config('app.locale')]);
    });
    Route::prefix('{locale}')->group(function(){
        // auth
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'login_process'])->name('login');
        Route::get('/forgot-password', [AuthController::class, 'forgot_password'])->name('forgot.password');
        Route::post('/forgot-password-process', [AuthController::class, 'forgot_password_process'])->name('forgot.password.process');
        Route::get('/reset-password', [AuthController::class, 'reset_password'])->name('reset.password');
        Route::post('/reset-password-process', [AuthController::class, 'reset_password_process'])->name('reset.password.process');
    });
});

// authenticated
Route::middleware(['auth'])->group(function () {
    Route::get('/',function(){
        return redirect()->route('dashboard',['locale'=>config('app.locale')]);
    });
    Route::prefix('{locale}')->group(function(){
        // dashboard
        Route::prefix('dashboard')->group(function(){
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        });
        // users
        Route::prefix('users')->group(function(){
            Route::get('/', [UserController::class, 'index'])->name('users');
            Route::get('/add', [UserController::class, 'create'])->name('users.add');
            Route::post('/add', [UserController::class, 'store'])->name('users.add');
        });
        // roles
        Route::prefix('roles')->group(function(){
            Route::get('/', [RoleController::class, 'index'])->name('roles');
            Route::get('/add', [RoleController::class, 'create'])->name('roles.add');
            Route::post('/add', [RoleController::class, 'store'])->name('roles.add');
        });
        // permission roles
        Route::prefix('permission-roles')->group(function(){
            Route::get('/', [PermissionRoleController::class, 'index'])->name('permission-roles');
            Route::get('/add', [PermissionRoleController::class, 'create'])->name('permission-roles.add');
            Route::post('/add', [PermissionRoleController::class, 'store'])->name('permission-roles.add');
        });
        // auth
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
