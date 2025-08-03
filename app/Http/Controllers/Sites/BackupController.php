<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BackupController extends Controller
{
    public function index(Site $site)
    {
        $this->authorize('view', $site);

        $backup_folder = 'site_backups/' . $site->id;
        $backups = collect(Storage::disk('sites')->directories($backup_folder))
            ->map(function ($backup) {
                return [
                    'name' => Str::afterLast($backup, '/'),
                    'path' => $backup,
                    'created_at' => \Carbon\Carbon::createFromTimestamp(Storage::disk('sites')->lastModified($backup)),
                ];
            })
            ->sortByDesc('created_at');

        return view('sites.backups.index', compact('site', 'backups'));
    }

    public function store(Site $site)
    {
        $this->authorize('update', $site);

        $backup_folder = 'site_backups/' . $site->id;
        $timestamp = now()->format('YmdHis');
        $backup_path = $backup_folder . '/' . $timestamp;

        try {
            Storage::disk('sites')->makeDirectory($backup_path);

            foreach (Storage::disk('sites')->allFiles($site->id) as $file) {
                if (Str::startsWith($file, 'site_backups')) continue;
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

    public function restore(Request $request, Site $site)
    {
        $this->authorize('update', $site);

        $request->validate([
            'backup_path' => 'required|string',
        ]);

        $backup_path = $request->input('backup_path');

        if (!Storage::disk('sites')->exists($backup_path)) {
            return redirect()
                ->route('sites.show', $site)
                ->with('error', 'Backup not found.');
        }

        try {
            // First, create a backup of the current state before restoring
            $this->store($site);

            // Clear the current site directory
            Storage::disk('sites')->deleteDirectory($site->id);
            Storage::disk('sites')->makeDirectory($site->id);
            $site->siteFiles()->delete();

            // Copy files from the backup
            foreach (Storage::disk('sites')->allFiles($backup_path) as $file) {
                $relative_path = Str::after($file, $backup_path . '/');
                $destination_path = $site->id . '/' . $relative_path;
                Storage::disk('sites')->copy($file, $destination_path);

                $site->siteFiles()->create([
                    'path' => $relative_path,
                    'content' => Storage::disk('sites')->get($destination_path),
                ]);
            }

            return redirect()
                ->route('sites.show', $site)
                ->with('status', 'Site restored successfully from backup.');
        } catch (\Exception $e) {
            return redirect()
                ->route('sites.show', $site)
                ->with('error', 'Failed to restore backup: ' . $e->getMessage());
        }
    }
}
