<?php

use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\User\AuthController;
use Illuminate\Support\Facades\Route;
use App\Models as Model;

Route::get('/', function () {
    $stats = [
        'users' => Model\User::count(),
        'sites' => Model\Site::count(),
        'pages' => Model\Page::count(),
    ];
    return view('pages.home', ['stats' => $stats]);
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
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
