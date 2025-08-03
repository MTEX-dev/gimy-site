<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Sites\SiteDeploymentController;
use App\Http\Controllers\Sites\SiteController;
use App\Http\Controllers\Sites\SiteFileController;
use App\Http\Controllers\Sites\BackupController;
use App\Http\Controllers\Sites\GithubController;
use App\Http\Controllers\User\SettingsController;
use App\Models as Model;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $stats = [
        'users' => Model\User::count(),
        'sites' => Model\Site::count(),
    ];
    return view('pages.home', ['stats' => $stats]);
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('sites', SiteController::class);
    Route::post('sites/{site}/pull', [GithubController::class, 'pull'])->name('sites.pull');
    Route::post('sites/{site}/backup', [BackupController::class, 'backup'])->name('sites.backup');
    Route::resource('sites.files', SiteFileController::class)->shallow();
    Route::resource('sites.deployments', SiteDeploymentController::class)->shallow();

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