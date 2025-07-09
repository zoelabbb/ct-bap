<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\UserIndex;
use App\Livewire\UserForm;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Routes untuk User CRUD (tanpa menggunakan middleware auth)
// Orang tanpa autentikasi bisa mengakses halaman ini
// Dan bisa melakukan operasi CRUD pada user
Route::get('/users', UserIndex::class)->name('users.index');
Route::get('/users/create', UserForm::class)->name('users.create');
Route::get('/users/{user}/edit', UserForm::class)->name('users.edit');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
