<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Mime\MimeTypes;

class SiteFileController extends Controller
{
    protected array $allowedMimeTypes = [
        'text/html',
        'text/css',
        'application/javascript',
        'application/json',
        'text/xml',
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/svg+xml',
        'image/webp',
        'font/woff',
        'font/woff2',
        'font/ttf',
        'font/otf',
        'video/mp4',
        'audio/mpeg',
        'text/plain',


        // Compatability
        'text/javascript',
        'application/x-javascript',
        'text/x-java-source',
        'text/x-typescript',
        'text/x-scss',
        'text/x-less',
        'application/x-css',
    ];

    public function create(Site $site)
    {
        return view('sites.files.create', compact('site'));
    }

    public function store(Request $request, Site $site)
    {
        $this->authorize('update', $site);

        if ($request->hasFile('files')) {
            $request->validate([
                'files' => 'required|array',
                'files.*' => [
                    'required',
                    'file',
                    'max:10240',
                    function ($attribute, $value, $fail) {
                        $mimeTypeGuesser = MimeTypes::getDefault();
                        $detectedMimeType = $mimeTypeGuesser->guessMimeType($value->getPathname());
                        
                        if (!$detectedMimeType) {
                            $detectedMimeType = $value->getMimeType();
                        }
                        
                        if (!in_array($detectedMimeType, $this->allowedMimeTypes)) {
                            $fail("The file type ({$detectedMimeType}) for {$value->getClientOriginalName()} is not allowed. Allowed types include HTML, CSS, JS, images, fonts, video/audio.");
                        }
                        
                        $originalName = $value->getClientOriginalName();
                        if (str_contains($originalName, '..') || str_contains($originalName, '/')) {
                            $fail("The filename '{$originalName}' contains invalid characters or paths.");
                        }
                    },
                ],
            ]);

            $uploadedCount = 0;
            $failedFiles = [];

            foreach ($request->file('files') as $file) {
                $path = $file->getClientOriginalName();
                $fullStoragePath = $site->id . '/' . $path;

                try {
                    $existingFile = $site->siteFiles()->where('path', $path)->first();

                    $content = $file->get();
                    Storage::disk('sites')->put($fullStoragePath, $content);

                    if ($existingFile) {
                        $existingFile->update(['content' => $content]);
                    } else {
                        $site->siteFiles()->create([
                            'path' => $path,
                            'content' => $content,
                        ]);
                    }
                    $uploadedCount++;
                } catch (\Exception $e) {
                    \Log::error("Failed to upload file for site {$site->id}: {$path}. Error: " . $e->getMessage());
                    $failedFiles[] = $path;
                }
            }

            if (!empty($failedFiles)) {
                $errorMessage = 'Some files failed to upload: ' . implode(', ', $failedFiles) . '.';
                return redirect()->route('sites.show', $site)->with('error', $errorMessage);
            }

            return redirect()->route('sites.show', $site)->with('status', "{$uploadedCount} file(s) uploaded successfully.");
        }

        $request->validate([
            'path' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9_\-\.\/]+$/',
                function ($attribute, $value, $fail) use ($site) {
                    if (str_contains($value, '..')) {
                        $fail("The path cannot contain directory traversal characters (..).");
                    }
                },
            ],
            'content' => 'required|string',
        ]);

        $filePath = trim($request->input('path'), '/');
        $content = $request->input('content');
        $fullStoragePath = $site->id . '/' . $filePath;

        $existingFile = $site->siteFiles()->where('path', $filePath)->first();

        Storage::disk('sites')->put($fullStoragePath, $content);

        if ($existingFile) {
            $existingFile->update(['content' => $content]);
            $message = 'File updated successfully.';
        } else {
            $site->siteFiles()->create([
                'path' => $filePath,
                'content' => $content,
            ]);
            $message = 'File created successfully.';
        }

        $dirname = pathinfo($filePath, PATHINFO_DIRNAME);
        if ($dirname == '.') $dirname = '';

        return redirect()->route('sites.explorer', ['site' => $site, 'path' => $dirname])->with('status', $message);
    }

    public function edit(SiteFile $file)
    {
        $this->authorize('update', $file->site);

        $filePathInfo = pathinfo($file->path);
        $filePathInfo['directory'] = $filePathInfo['dirname'] ?? '';
        $breadcrumbs = collect(explode('/', $filePathInfo['directory']))->filter();

        $fileContentFromDisk = Storage::disk('sites')->get($file->site->id . '/' . $file->path);
        $file->content = $fileContentFromDisk;

        return view('sites.files.edit', compact('file', 'breadcrumbs', 'filePathInfo'));
    }

    public function update(Request $request, SiteFile $file)
    {
        $this->authorize('update', $file->site);

        $content = $request->input('content');

        Storage::disk('sites')->put($file->site->id . '/' . $file->path, $content);

        $file->update(['content' => $content]);

        return redirect()->route('sites.explorer', ['site' => $file->site, 'path' => pathinfo($file->path)['dirname']])->with('status', 'File updated successfully.');
    }

    public function destroy(SiteFile $file)
    {
        $this->authorize('update', $file->site);

        Storage::disk('sites')->delete($file->site->id . '/' . $file->path);

        $file->delete();

        $dirname = pathinfo($file->path, PATHINFO_DIRNAME);
        if ($dirname == '.') $dirname = '';

        return redirect()->route('sites.explorer', ['site' => $file->site, 'path' => $dirname])->with('status', 'File deleted successfully.');
    }
}