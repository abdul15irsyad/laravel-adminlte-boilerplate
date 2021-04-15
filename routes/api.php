<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionRoleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix'=>'v1','middleware'=>'api'],function () {
    // users
    Route::prefix('users')->group(function(){
        Route::post('/', [UserController::class, 'get_users'])->name('api.v1.users');
    });
    // roles
    Route::prefix('roles')->group(function(){
        Route::post('/', [RoleController::class, 'get_roles'])->name('api.v1.roles');
    });
    // permission roles
    Route::prefix('permission-roles')->group(function(){
        Route::post('/', [PermissionRoleController::class, 'get_permission_roles'])->name('api.v1.permission-roles');
    });
});
