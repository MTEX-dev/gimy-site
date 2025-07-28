<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Asset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AssetController extends Controller
{
    public function create(Site $site): View
    {
        $this->authorize('update', $site);
        return view('assets.create', ['site' => $site]);
    }

    public function store(Request $request, Site $site): RedirectResponse
    {
        $this->authorize('update', $site);

        $validated = $request->validate([
            'file' => ['required', 'file', 'max:10240'], // Max 10MB file size
            'folder' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\/_-]*$/'], // Alphanumeric, slash, hyphen, underscore
        ]);

        $uploadedFile = $request->file('file');
        $fileName = $uploadedFile->getClientOriginalName();
        $mimeType = $uploadedFile->getMimeType();
        $fileSize = $uploadedFile->getSize();

        // Determine the asset type
        $type = 'other';
        if (str_starts_with($mimeType, 'image/')) {
            $type = 'image';
        } elseif ($mimeType === 'text/css') {
            $type = 'css';
        } elseif ($mimeType === 'application/javascript' || $mimeType === 'text/javascript') {
            $type = 'js';
        } elseif (str_starts_with($mimeType, 'font/')) {
            $type = 'font';
        }

        // Clean and normalize folder path
        $folder = trim($validated['folder'] ?? '', '/');
        $assetPath = empty($folder) ? '/' . $fileName : '/' . $folder . '/' . $fileName;

        // Ensure unique path within the site
        if ($site->assets()->where('path', $assetPath)->exists()) {
            return back()->withErrors(['file' => 'An asset with this path and filename already exists.'])->withInput();
        }

        // Store the file
        Storage::disk('sites')->putFileAs($site->id . $assetPath, $uploadedFile, $fileName);
        // Correct path for putFileAs is the directory, and the file name is the second argument.
        // Let's correct this for storing in `site_id/folder/filename`
        $fullPathInStorage = $site->id . (empty($folder) ? '' : '/' . $folder) . '/' . $fileName;
        Storage::disk('sites')->put($fullPathInStorage, $uploadedFile->get());


        $site->assets()->create([
            'file_name' => $fileName,
            'path' => $assetPath, // Store relative path in DB
            'mime_type' => $mimeType,
            'type' => $type,
            'file_size' => $fileSize,
        ]);

        return redirect()->route('sites.edit', $site)->with('status', 'asset-uploaded');
    }

    public function edit(Site $site, Asset $asset): View
    {
        $this->authorize('update', $site);
        abort_if($asset->site_id !== $site->id, 404); // Ensure asset belongs to site

        return view('assets.edit', ['site' => $site, 'asset' => $asset]);
    }

    public function update(Request $request, Site $site, Asset $asset): RedirectResponse
    {
        $this->authorize('update', $site);
        abort_if($asset->site_id !== $site->id, 404);

        $validated = $request->validate([
            'new_file' => ['nullable', 'file', 'max:10240'], // Allow replacing the file
            'file_name' => [
                'required',
                'string',
                'max:255',
                // Ensure unique name within its folder and site
                Rule::unique('assets')->where(function ($query) use ($site, $asset) {
                    // Extract folder from current path and new file_name
                    $oldFolder = dirname($asset->path);
                    if ($oldFolder === '.') $oldFolder = ''; // Root folder
                    $newPath = '/' . ltrim($oldFolder . '/' . request('file_name'), '/');
                    return $query->where('site_id', $site->id)
                                 ->where('path', $newPath)
                                 ->where('id', '!=', $asset->id);
                })
            ],
            'folder' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\/_-]*$/'],
        ]);

        $oldFullPathInStorage = "{$site->id}/{$asset->path}";

        // Calculate new path
        $folder = trim($validated['folder'] ?? '', '/');
        $newAssetPath = empty($folder) ? '/' . $validated['file_name'] : '/' . $folder . '/' . $validated['file_name'];
        $newFullPathInStorage = "{$site->id}/{$newAssetPath}";

        if ($request->hasFile('new_file')) {
            $uploadedFile = $request->file('new_file');
            $newFileSize = $uploadedFile->getSize();
            $newMimeType = $uploadedFile->getMimeType();

            // Delete old file
            Storage::disk('sites')->delete($oldFullPathInStorage);
            // Store new file
            Storage::disk('sites')->put($newFullPathInStorage, $uploadedFile->get());

            $asset->update([
                'file_name' => $validated['file_name'],
                'path' => $newAssetPath,
                'mime_type' => $newMimeType,
                'file_size' => $newFileSize,
                'type' => (str_starts_with($newMimeType, 'image/') ? 'image' : ($newMimeType === 'text/css' ? 'css' : ($newMimeType === 'application/javascript' || $newMimeType === 'text/javascript' ? 'js' : (str_starts_with($newMimeType, 'font/') ? 'font' : 'other')))),
            ]);
        } elseif ($asset->path !== $newAssetPath) {
            // Only file name/folder changed, move the existing file
            if (Storage::disk('sites')->exists($oldFullPathInStorage)) {
                 Storage::disk('sites')->move($oldFullPathInStorage, $newFullPathInStorage);
            }
            $asset->update([
                'file_name' => $validated['file_name'],
                'path' => $newAssetPath,
            ]);
        } else {
             $asset->update([
                'file_name' => $validated['file_name'],
                'path' => $newAssetPath,
             ]);
        }

        return back()->with('status', 'asset-updated');
    }


    public function destroy(Site $site, Asset $asset): RedirectResponse
    {
        $this->authorize('delete', $site);
        abort_if($asset->site_id !== $site->id, 404);

        // Deleting the asset record will trigger the model's deleting event
        // which removes the file from storage.
        // Also, detach from any pages
        $asset->pages()->detach();
        $asset->delete();

        return redirect()->route('sites.edit', $site)->with('status', 'asset-deleted');
    }
}