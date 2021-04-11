<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', 'AuthController@index')->name('login');
    Route::post('/login', 'AuthController@login')->name('login');
    Route::get('/forgot-password', 'AuthController@forgot_password')->name('forgot.password');
    Route::post('/forgot-password', 'AuthController@forgot_password_process')->name('forgot.password');
    Route::get('/reset-password/{token?}', 'AuthController@reset_password')->name('reset.password');
    Route::post('/reset-password', 'AuthController@reset_password_process')->name('reset.password');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
