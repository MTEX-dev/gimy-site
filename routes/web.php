<?php

use App\Http\Controllers\FileExplorerController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Sites\SiteDeploymentController;
use App\Http\Controllers\Sites\SiteController;
use App\Http\Controllers\Sites\SiteFileController;
use App\Http\Controllers\Sites\BackupController;
use App\Http\Controllers\Sites\GithubController;
use App\Http\Controllers\Sites\ViewController;
use App\Http\Controllers\User\SettingsController;
use App\Models as Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    Route::resource('sites', SiteController::class);
    Route::get('sites/{site}/explorer/{path?}', [FileExplorerController::class, 'explore'])->name('sites.explorer')->where('path', '.*');
    Route::post('sites/{site}/pull', [GithubController::class, 'pull'])->name('sites.pull');
    Route::resource('sites.backups', BackupController::class)->only(['index', 'store']);
    Route::post('sites/{site}/backups/restore', [BackupController::class, 'restore'])->name('sites.backups.restore');
    Route::resource('sites.files', SiteFileController::class)->shallow();
    Route::resource('sites.deployments', SiteDeploymentController::class)->shallow();
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

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


Route::get('/locale/{locale}', function ($locale) {
    if (array_key_exists($locale, config('locales.supported'))) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }
    return redirect()->back();
})->name('locale.switch');


Route::get('/legal/{section}', [PageController::class, 'legal'])->name('legal');

Route::get('/sites/{site}/preview/{path?}', [ViewController::class, 'show'])->name('sites.preview')->where('path', '.*');