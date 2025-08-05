<?php

use App\Http\Controllers\Sites\ViewController;
use App\Models\Site;
use Illuminate\Support\Facades\Route;

// Middleware to resolve the Site model from the subdomain
Route::middleware(function ($request, $next) {
    $subdomain = $request->route('subdomain');

    // Find the site based on the subdomain
    $site = Site::where('subdomain', $subdomain)->first();

    if (!$site) {
        // return redirect(route('home'))->with('error', 'Site not found.');
        abort(404, 'Site not found.');
    }

    $request->route()->setParameter('site', $site);

    return $next($request);
})->group(function () {#
    Route::get('/{path?}', [ViewController::class, 'show'])
        ->name('site.view')
        ->where('path', '.*');
});
 