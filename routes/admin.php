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

    // Route::resource('tenants', 'TenantsController')->except(['store', 'update']);

    // Tenants
    Route::livewire('tenants', 'admin.tenants.tenants-list')
        ->layout('admin.layouts.app')
        ->name('tenants.index')
        ->middleware('can:view-tenant-list');

    Route::livewire('tenants/create', 'admin.tenants.create-tenant')
        ->layout('admin.layouts.app')
        ->name('tenants.create')
        ->middleware('can:create-tenant');

    Route::livewire('tenants/{uuid}/edit', 'admin.tenants.edit-tenant')
        ->layout('admin.layouts.app')
        ->name('tenants.edit')
        ->middleware('can:edit-tenant');

    // Administrators
    Route::livewire('users', 'admin.users.users-list')
        ->layout('admin.layouts.app')
        ->name('users.index')
        ->middleware('can:view-administrator-list');

    Route::livewire('users/create', 'admin.users.create-user')
        ->layout('admin.layouts.app')
        ->name('users.create')
        ->middleware('can:create-administrator');

    Route::livewire('users/{uuid}/edit', 'admin.users.edit-user')
        ->layout('admin.layouts.app')
        ->name('users.edit')
        ->middleware('can:edit-administrator');

    // Roles
    Route::livewire('roles', 'admin.roles.roles-list')
        ->layout('admin.layouts.app')
        ->name('roles.index')
        ->middleware('can:view-roles');

    Route::livewire('roles/{id}/edit', 'admin.roles.edit-role')
        ->layout('admin.layouts.app')
        ->name('roles.edit')
        ->middleware('can:edit-role');

    Route::livewire('roles/create', 'admin.roles.create-role')
        ->layout('admin.layouts.app')
        ->name('roles.create')
        ->middleware('can:create-role');

    // Profile
    Route::livewire('profile', 'admin.profile')
        ->layout('admin.layouts.app')
        ->name('profile');
});
