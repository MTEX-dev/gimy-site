// app/Http/Controllers/SiteFileController.php
<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SiteFileController extends Controller
{
    public function __construct()
    {
        // Policy authorization for Site model is handled in SitePolicy.
        // For SiteFileController, we need to ensure the user owns the site.
        // We can either use a middleware or explicit authorize calls.
        // Let's use explicit authorize calls as done in PageController now.
    }

    public function upload(Request $request, Site $site)
    {
        // Authorize this action using the Site policy
        $this->authorize('update', $site);

        $request->validate([
            'files.*' => 'required|file|max:20480', // 20MB per file, adjust as needed
            'paths.*' => 'required|string', // Relative path for each file submitted from JS
        ]);

        $uploadedFiles = $request->file('files');
        $relativePaths = $request->input('paths');

        $errors = [];
        $uploadedAssetCount = 0;

        foreach ($uploadedFiles as $index => $file) {
            $relativePath = $relativePaths[$index];
            $directory = dirname($relativePath);
            $fileName = basename($relativePath);

            // Sanitize path to prevent directory traversal
            // Remove leading/trailing slashes, and any '/./' or '/../'
            $directory = preg_replace('/^\.|\/\.$|\/\.\.\/|\.\.\//', '', trim($directory, '/'));
            if ($directory === '.') { // If after cleaning, it's just '.', make it empty.
                $directory = '';
            }

            // Define the full path within the site's public storage
            $siteStoragePath = "sites/{$site->id}" . ($directory ? '/' . $directory : '');
            $fullStoragePath = $siteStoragePath . '/' . $fileName; // This is the path on disk

            try {
                // Ensure the directory exists
                Storage::disk('public')->makeDirectory($siteStoragePath);

                // Store the file
                // Use `putFileAs` to control the filename
                Storage::disk('public')->putFileAs($siteStoragePath, $file, $fileName);

                // Check if an asset with this path already exists for this site
                $existingAsset = $site->assets()->where('path', ($directory ? $directory . '/' : '') . $fileName)->first();

                if ($existingAsset) {
                    // Update existing asset details if file content changed or re-uploaded
                    $existingAsset->update([
                        'name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                    ]);
                    // You might want to log this as an overwrite
                } else {
                    // Create new asset record
                    Asset::create([
                        'site_id' => $site->id,
                        'name' => $file->getClientOriginalName(),
                        'path' => ($directory ? $directory . '/' : '') . $fileName, // Store relative path for URL generation
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                    ]);
                }
                $uploadedAssetCount++;

            } catch (\Exception $e) {
                $errors[] = "Failed to upload {$relativePath}: " . $e->getMessage();
            }
        }

        if (empty($errors)) {
            return response()->json(['success' => "Successfully uploaded {$uploadedAssetCount} files.", 'reload' => true], 200);
        } else {
            return response()->json(['error' => 'Some files failed to upload.', 'details' => $errors, 'reload' => true], 400);
        }
    }

    public function destroy(Site $site, Asset $asset)
    {
        // Authorize this action using the Site policy or Asset policy directly.
        // It's better to authorize against the asset and let its policy check site ownership.
        $this->authorize('delete', $asset);

        // Additional check: Ensure the asset actually belongs to the provided site ID from the route.
        // This prevents someone trying to delete an asset from a different site.
        if ($asset->site_id !== $site->id) {
            return back()->with('error', 'Unauthorized action: Asset does not belong to this site.')->withInput();
        }

        // Delete the file from storage
        // Ensure the path is correctly prepended with the site's ID folder
        $filePathInStorage = "sites/{$site->id}/{$asset->path}";
        if (Storage::disk('public')->exists($filePathInStorage)) {
            Storage::disk('public')->delete($filePathInStorage);
        } else {
            // Log if file not found on disk but still in DB, might indicate an inconsistency
            \Log::warning("Asset file not found on disk: {$filePathInStorage} for asset ID: {$asset->id}");
        }

        // Delete the record from the database
        $asset->delete();

        return back()->with('success', 'File deleted successfully.');
    }
}