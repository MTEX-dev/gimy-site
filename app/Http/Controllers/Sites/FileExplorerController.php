<?php

namespace App\Http\Controllers\Sites;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class FileExplorerController extends Controller
{
    public function explore(Request $request, Site $site, $path = null)
    {
        $this->authorize('view', $site);

        $directory = $site->id . ($path ? '/' . $path : '');

        // Prevent directory traversal
        if (str_contains($path, '..')) {
            abort(403, 'Invalid path.');
        }

        $files = Storage::disk('sites')->files($directory);
        $directories = Storage::disk('sites')->directories($directory);

        // Breadcrumbs
        $breadcrumbs = collect(explode('/', $path))->filter();

        return view('sites.explorer.index', compact('site', 'files', 'directories', 'path', 'breadcrumbs'));
    }
}