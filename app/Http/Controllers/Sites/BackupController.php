<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BackupController extends Controller
{
    public function backup(Site $site)
    {
        $this->authorize('update', $site);

        $backup_folder = 'site_backups/' . $site->id;
        $timestamp = now()->format('YmdHis');
        $backup_path = $backup_folder . '/' . $timestamp;

        try {
            Storage::disk('sites')->makeDirectory($backup_path);

            foreach (Storage::disk('sites')->allFiles($site->id) as $file) {
                $relative_path = Str::after($file, $site->id . '/');
                Storage::disk('sites')->copy($file, $backup_path . '/' . $relative_path);
            }

            return redirect()
                ->route('sites.show', $site)
                ->with('status', 'Site files backed up successfully to: ' . $backup_path);
        } catch (\Exception $e) {
            return redirect()
                ->route('sites.show', $site)
                ->with('error', 'Failed to create backup: ' . $e->getMessage());
        }
    }
}
