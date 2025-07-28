<?php

use App\Http\Controllers\Site\AssetController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SiteController;
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




Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('sites', SiteController::class);

    Route::prefix('sites/{site}')->name('sites.')->group(function () {
        Route::resource('pages', PageController::class);
        Route::post('/files/upload', [SiteFileController::class, 'upload'])->name('files.upload');
        Route::delete('/files/{asset}', [SiteFileController::class, 'destroy'])->name('files.destroy');
    });
});

Route::domain('{subdomain}.' . config('app.domain'))->group(function () {
    Route::get('/{slug?}', [SiteController::class, 'showSiteContent'])->name('site.show');
});

/*Route::get('/dashboard', function () {
    return view('dashboard', [
        'sites' => Auth::user()->sites()->get(),
    ]);
})->middleware(['auth'])->name('dashboard');*/

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

        /*
    // Site Management Routes
    Route::resource('sites', SiteController::class)->except(['index', 'show']); // handled by subdomain routing
    Route::prefix('sites/{site}')->name('sites.')->group(function () {
        // Pages within a Site
        Route::resource('pages', PageController::class)->except(['index', 'show']);

        // Assets within a Site
        Route::resource('assets', AssetController::class)->except(['show']);
    });
    */
});