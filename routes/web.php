<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ActivityLogController,
    AuthController,
    DashboardController,
    PermissionController,
    PermissionRoleController,
    ProfileController,
    RoleController,
    UserController,
};

// no middleware
Route::get('/verify-email-process', [AuthController::class, 'verify_email_process'])->name('verify-email-process');

// not authenticated
Route::middleware(['guest'])->group(function () {
    Route::get('/',function(){
        return redirect()->route('login');
    })->name('home');
        // auth
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'login_process'])->name('login');
    Route::get('/forgot-password', [AuthController::class, 'forgot_password'])->name('forgot-password');
    Route::post('/forgot-password-process', [AuthController::class, 'forgot_password_process'])->name('forgot-password.process');
    Route::get('/reset-password', [AuthController::class, 'reset_password'])->name('reset-password');
    Route::post('/reset-password-process', [AuthController::class, 'reset_password_process'])->name('reset-password.process');
});

// authenticated
Route::middleware(['auth'])->group(function () {
    Route::get('/',function(){
        return redirect()->route('dashboard');
    })->name('home');
    // dashboard
    Route::prefix('dashboard')->group(function(){
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });
    // users
    Route::prefix('users')->group(function(){
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/create', [UserController::class, 'store'])->name('users.create');
        Route::get('/{id}/detail', [UserController::class, 'detail'])->name('users.detail');
        Route::get('/{id}/update', [UserController::class, 'update'])->name('users.update');
        Route::post('/{id}/update', [UserController::class, 'save'])->name('users.update');
        Route::get('/{id}/delete', [UserController::class, 'delete'])->name('users.delete');
    });
    // roles
    Route::prefix('roles')->group(function(){
        Route::get('/', [RoleController::class, 'index'])->name('roles');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/create', [RoleController::class, 'store'])->name('roles.create');
        Route::get('/{id}/detail', [RoleController::class, 'detail'])->name('roles.detail');
        Route::get('/{id}/update', [RoleController::class, 'update'])->name('roles.update');
        Route::post('/{id}/update', [RoleController::class, 'save'])->name('roles.update');
        Route::get('/{id}/delete', [RoleController::class, 'delete'])->name('roles.delete');
    });
    // roles
    Route::prefix('permissions')->group(function(){
        Route::get('/', [PermissionController::class, 'index'])->name('permissions');
        // Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
        // Route::post('/create', [PermissionController::class, 'store'])->name('permissions.create');
        Route::get('/{id}/detail', [PermissionController::class, 'detail'])->name('permissions.detail');
    });
    // activity log
    Route::prefix('activity-log')->group(function(){
        Route::get('/', [ActivityLogController::class, 'index'])->name('activity-log');
        Route::get('/{id}/detail', [ActivityLogController::class, 'detail'])->name('activity-log.detail');
    });
    // profile
    Route::prefix('profile')->group(function(){
        Route::get('/', [ProfileController::class, 'index'])->name('profile');
        Route::get('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/update', [ProfileController::class, 'save'])->name('profile.update');
        Route::get('/change-password', [ProfileController::class, 'change_password'])->name('profile.change-password');
        Route::post('/change-password', [ProfileController::class, 'save_password'])->name('profile.change-password');
    });
    // auth
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
