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
        $request->validate([
            'path' => 'required|string',
            'content' => 'required|string',
        ]);

        $this->authorize('update', $site);

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
        return view('sites.files.edit', compact('file'));
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

        return redirect()->route('sites.show', $file->site);
    }

    public function destroy(SiteFile $file)
    {
        $this->authorize('update', $file->site);

        Storage::disk('sites')->delete($file->site->id . '/' . $file->path);

        $file->delete();

        return redirect()->route('sites.show', $file->site);
    }
}
