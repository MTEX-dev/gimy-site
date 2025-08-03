<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\SiteFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteFileController extends Controller
{
    public function create(Site $site)
    {
        return view('sites.files.create', compact('site'));
    }

    public function store(Request $request, Site $site)
    {
        $this->authorize('update', $site);

        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required|file|max:10240', // 10MB max
            ]);

            $file = $request->file('file');
            $path = $file->getClientOriginalName();

            if (str_contains($path, '..')) {
                return redirect()->route('sites.show', $site)->with('error', 'Invalid file path.');
            }

            $content = file_get_contents($file);
            Storage::disk('sites')->put($site->id . '/' . $path, $content);

            $site->siteFiles()->updateOrCreate(
                ['path' => $path],
                ['content' => $content]
            );

            return redirect()->route('sites.show', $site)->with('status', 'File uploaded successfully.');
        }

        $request->validate([
            'path' => 'required|string',
            'content' => 'required|string',
        ]);

        $filePath = $request->input('path');
        $content = $request->input('content');

        Storage::disk('sites')->put($site->id . '/' . $filePath, $content);

        $site->siteFiles()->create([
            'path' => $filePath,
            'content' => $content,
        ]);

        return redirect()->route('sites.show', $site);
    }

    public function edit(SiteFile $file)
    {
        $this->authorize('update', $file->site);

        $filePathInfo = pathinfo($file->path);
        $filePathInfo['directory'] = $filePathInfo['dirname'] ?? '';
        $breadcrumbs = collect(explode('/', $filePathInfo['directory']))->filter();

        return view('sites.files.edit', compact('file', 'breadcrumbs', 'filePathInfo'));
    }

    public function update(Request $request, SiteFile $file)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $this->authorize('update', $file->site);

        $content = $request->input('content');

        Storage::disk('sites')->put($file->site->id . '/' . $file->path, $content);

        $file->update([
            'content' => $content,
        ]);

        return redirect()->route('sites.explorer', ['site' => $file->site, 'path' => pathinfo($file->path)['dirname']]);
    }

    public function destroy(SiteFile $file)
    {
        $this->authorize('update', $file->site);

        Storage::disk('sites')->delete($file->site->id . '/' . $file->path);

        $file->delete();

        return redirect()->route('sites.explorer', ['site' => $file->site, 'path' => pathinfo($file->path)['dirname']]);
    }
}