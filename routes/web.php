<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\SettingsController;
use Illuminate\Support\Facades\Route;
use App\Models as Model;

Route::get('/', function () {
    $stats = [
        'users' => Model\User::count(),
    ];
    return view('pages.home', ['stats' => $stats]);
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('settings')
        ->name('user.settings.')
        ->group(function () {
            Route::get('/', [SettingsController::class, 'show'])->name('show');
            Route::patch('/locale', [SettingsController::class, 'updateLocale'])->name('updateLocale');
            Route::patch('/password', [SettingsController::class, 'updatePassword'])->name('updatePassword');
            Route::delete('/', [SettingsController::class, 'destroy'])->name('destroy');
        });
});

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});
