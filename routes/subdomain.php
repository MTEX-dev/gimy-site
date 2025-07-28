<?php

use App\Http\Controllers\Site\SiteController; // Will serve the files
use App\Models\Site;
use App\Models\Asset;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

// This route handles all requests for dynamic subdomains.
// The {path?} parameter captures the requested file or directory path.
Route::get('{path?}', function ($subdomain, $path = null) {
    // Basic validation and sanitization for the path to prevent directory traversal
    $path = trim($path, '/');
    if (str_contains($path, '..')) {
        abort(403, 'Invalid path.');
    }

    $site = Site::where('subdomain', $subdomain)->first();

    if (!$site || $site->status !== 'active') {
        abort(404, 'Site not found or inactive.');
    }

    // Determine the actual file to serve
    $filePathInStorage = '';
    $mimeType = 'text/html'; // Default for HTML pages

    // If no path is specified, it's the homepage
    if (empty($path)) {
        $homepage = $site->pages()->where('is_homepage', true)->first();
        // If there's a homepage entry in pages table, find its associated HTML asset
        if ($homepage) {
            $htmlAsset = $homepage->assets()->where('type', 'html')->first();
            if ($htmlAsset) {
                $filePathInStorage = "{$site->id}/{$htmlAsset->path}";
                $mimeType = $htmlAsset->mime_type;
            } else {
                // Fallback: look for an index.html asset directly linked to the site or a default
                $defaultIndex = $site->assets()->where('path', '/index.html')->first();
                if ($defaultIndex) {
                    $filePathInStorage = "{$site->id}/{$defaultIndex->path}";
                    $mimeType = $defaultIndex->mime_type;
                }
            }
        } else {
             // Fallback if no page entry is homepage, look for a default index.html asset
            $defaultIndex = $site->assets()->where('path', '/index.html')->first();
            if ($defaultIndex) {
                $filePathInStorage = "{$site->id}/{$defaultIndex->path}";
                $mimeType = $defaultIndex->mime_type;
            }
        }

        // If no homepage or index.html found, return 404
        if (empty($filePathInStorage)) {
            abort(404, 'No homepage found for this site.');
        }

    } else {
        // Try to find the asset directly by its path (e.g., /css/style.css, /about.html)
        $asset = $site->assets()->where('path', '/' . $path)->first();

        if ($asset) {
            $filePathInStorage = "{$site->id}/{$asset->path}";
            $mimeType = $asset->mime_type;
        } else {
            // If the requested path is a directory and not an asset, try to find an index.html inside it
            // e.g., if path is 'blog/', try 'blog/index.html'
            $indexPath = rtrim($path, '/') . '/index.html';
            $indexAsset = $site->assets()->where('path', '/' . $indexPath)->first();
            if ($indexAsset) {
                $filePathInStorage = "{$site->id}/{$indexAsset->path}";
                $mimeType = $indexAsset->mime_type;
            } else {
                 // Finally, if it's still not found, return 404
                abort(404, 'Asset or page not found.');
            }
        }
    }

    // Check if the file actually exists on disk
    if (!Storage::disk('sites')->exists($filePathInStorage)) {
        abort(404, 'File not found on server.');
    }

    // Serve the file
    $fileContents = Storage::disk('sites')->get($filePathInStorage);

    // If it's an HTML file, we can optionally parse it to inject dynamic content or links to other assets.
    // For a static hosting service, serving as-is is usually fine.
    // For more dynamic behavior (e.g., replacing placeholders for asset URLs), you might need a different approach here.

    return response($fileContents)->header('Content-Type', $mimeType);

})->where('path', '.*'); // Ensures {path?} matches everything including slashes and dots.