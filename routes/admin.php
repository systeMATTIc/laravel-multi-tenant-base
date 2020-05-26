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

Route::middleware(['guest:admin'])->group(function () {
    Route::view('login', 'admin.auth.login')->name('login');
    Route::view('register', 'admin.auth.register')->name('register');
});

Route::view('password/reset', 'admin.auth.passwords.email')->name('password.request');
Route::get('password/reset/{token}', 'Auth\PasswordResetController')->name('password.reset');

Route::middleware('auth:admin')->group(function () {
    
    Route::view('/', 'admin.welcome')->name('home');

    Route::view('email/verify', 'admin.auth.verify')->middleware('throttle:6,1')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'Auth\EmailVerificationController')->middleware('signed')->name('verification.verify');

    Route::post('logout', 'Auth\LogoutController')->name('logout');

    Route::view('password/confirm', 'admin.auth.passwords.confirm')->name('password.confirm');

    Route::resource('tenants', 'TenantsController')->except(['store', 'update']);

    Route::resource('users', 'AdministratorsController')->except(['store', 'update']);

    Route::resource('roles', 'RolesController')->except(['store', 'update']);
});