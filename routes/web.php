<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web and tenant" middleware group. 
| Now create something great!
|
*/


Route::middleware(['guest'])->group(function () {
    Route::view('login', 'auth.login')->name('login');
    Route::view('register', 'auth.register')->name('register');
});

Route::view('password/reset', 'auth.passwords.email')->name('password.request');
Route::get('password/reset/{token}', 'Auth\PasswordResetController')->name('password.reset');

Route::middleware('auth')->group(function () {

    Route::view('/', 'welcome')->name('home');

    Route::view('email/verify', 'auth.verify')->middleware('throttle:6,1')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'Auth\EmailVerificationController')->middleware('signed')->name('verification.verify');

    Route::post('logout', 'Auth\LogoutController')->name('logout');

    Route::view('password/confirm', 'auth.passwords.confirm')->name('password.confirm');

    // Users
    Route::livewire('users', 'users.users-list')
        ->layout('layouts.app')
        ->name('users.index')
        ->middleware('can:view-users');

    Route::livewire('users/create', 'users.create-user')
        ->layout('layouts.app')
        ->name('users.create')
        ->middleware('can:create-user');

    Route::livewire('users/{uuid}/edit', 'users.edit-user')
        ->layout('layouts.app')
        ->name('users.edit')
        ->middleware('can:edit-user');

    // Roles
    Route::livewire('roles', 'roles.roles-list')
        ->layout('layouts.app')
        ->name('roles.index')
        ->middleware('can:view-roles');

    Route::livewire('roles/{id}/edit', 'roles.edit-role')
        ->layout('layouts.app')
        ->name('roles.edit')
        ->middleware('can:edit-role');

    Route::livewire('roles/create', 'roles.create-role')
        ->layout('layouts.app')
        ->name('roles.create')
        ->middleware('can:create-role');

    // Profile
    Route::livewire('profile', 'profile')
        ->layout('layouts.app')
        ->name('profile');
});
