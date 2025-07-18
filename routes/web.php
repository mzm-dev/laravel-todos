<?php

use App\Livewire\Categories\CategoryIndex;
use App\Livewire\Permissions\PermissionIndex;
use App\Livewire\Roles\RoleIndex;
use App\Livewire\Tasks\TaskIndex;
use App\Livewire\Users\UserIndex;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::view('profile', 'profile')->name('profile')->can('Urus Profil');
    Route::get('/tasks', TaskIndex::class)->name('task.index')->can('Urus Tugasan');
    Route::get('/categories', CategoryIndex::class)->name('category.index')->can('Urus Kategori Tugasan');

    Route::get('/permissions', PermissionIndex::class)->name('permission.index')->can('Urus Permission');
    Route::get('/roles', RoleIndex::class)->name('role.index')->can('Urus Peranan');
    Route::get('/users', UserIndex::class)->name('user.index')->can('Urus Pengguna');
});

require __DIR__ . '/auth.php';
