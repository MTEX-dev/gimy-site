<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\SettingsController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'create'])->name('register');
    Route::post('register', [AuthController::class, 'store']);
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

    // Example Dashboard Route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // User Settings
    Route::prefix('user/settings')->name('user.settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'edit'])->name('edit');
        Route::patch('/', [SettingsController::class, 'update'])->name('update');
        Route::delete('/', [SettingsController::class, 'destroy'])->name('destroy');
    });

    // Site Management (Future)
    // Route::resource('sites', SiteController::class);
});

Route::get('/', function () {
    return view('welcome');
});
