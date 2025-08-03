<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\SiteFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class GithubController extends Controller
{
    public function pull(Site $site)
    {
        $this->authorize('update', $site);

        if (!$site->github_url) {
            return redirect()
                ->route('sites.show', $site)
                ->with('error', 'No GitHub URL configured for this site.');
        }

        $github_url_parts = explode('/', $site->github_url);
        if (count($github_url_parts) < 5) {
             return redirect()
                ->route('sites.show', $site)
                ->with('error', 'Invalid GitHub URL format. Expected: https://github.com/owner/repo');
        }

        $owner = $github_url_parts[3];
        $repo = Str::of($github_url_parts[4])->replace('.git', '');

        $userGitHubToken = Auth::user()->github_token ?? null;

        try {
            $headers = ['Accept' => 'application/vnd.github.v3+json'];
            if ($userGitHubToken) {
                $headers['Authorization'] = 'token ' . $userGitHubToken;
            }

            $response = Http::withHeaders($headers)
                            ->get("https://api.github.com/repos/{$owner}/{$repo}/zipball/master"); // Using zipball for full repo download

            if ($response->status() === 404) {
                return redirect()
                    ->route('sites.show', $site)
                    ->with('error', 'Repository not found. Please check the URL.');
            } elseif ($response->status() === 403 || $response->status() === 401) {
                if ($userGitHubToken) {
                     return redirect()
                        ->route('sites.show', $site)
                        ->with('error', 'Authentication failed or insufficient permissions for this repository. Please re-authenticate GitHub.');
                } else {
                    return redirect()
                        ->route('sites.show', $site)
                        ->with('error', 'Access denied to this repository. It might be private. Please connect your GitHub account via OAuth.');
                }
            }

            $response->throw();

            $temp_zip_path = tempnam(sys_get_temp_dir(), 'github_pull') . '.zip';
            file_put_contents($temp_zip_path, $response->body());

            $zip = new ZipArchive();
            if ($zip->open($temp_zip_path) === TRUE) {
                $backup_folder = 'site_backups/' . $site->id;
                $timestamp = now()->format('YmdHis');
                $backup_path = $backup_folder . '/' . $timestamp;
                Storage::disk('sites')->makeDirectory($backup_path);

                foreach (Storage::disk('sites')->allFiles($site->id) as $file) {
                    $relative_path = Str::after($file, $site->id . '/');
                    Storage::disk('sites')->copy($file, $backup_path . '/' . $relative_path);
                }

                Storage::disk('sites')->deleteDirectory($site->id);
                Storage::disk('sites')->makeDirectory($site->id);
                $site->siteFiles()->delete();

                $extract_path = Storage::disk('sites')->path($site->id);
                $zip->extractTo($extract_path);
                $zip->close();

                unlink($temp_zip_path);

                $extracted_repo_folder = glob($extract_path . '/*', GLOB_ONLYDIR)[0] ?? null;

                if ($extracted_repo_folder) {
                    $all_files = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($extracted_repo_folder, \RecursiveDirectoryIterator::SKIP_DOTS),
                        \RecursiveIteratorIterator::SELF_FIRST
                    );

                    foreach ($all_files as $item) {
                        $relative_path = Str::replaceFirst($extracted_repo_folder . '/', '', $item->getPathname());
                        $destination_path = $site->id . '/' . $relative_path;

                        if ($item->isDir()) {
                            Storage::disk('sites')->makeDirectory($destination_path);
                        } else {
                            $content = file_get_contents($item->getPathname());
                            Storage::disk('sites')->put($destination_path, $content);

                            $site->siteFiles()->create([
                                'path' => $relative_path,
                                'content' => $content,
                            ]);
                        }
                    }
                    Storage::disk('sites')->deleteDirectory($site->id . '/' . basename($extracted_repo_folder));
                } else {
                    return redirect()
                        ->route('sites.show', $site)
                        ->with('error', 'Failed to find extracted repository content.');
                }

                return redirect()
                    ->route('sites.show', $site)
                    ->with('status', 'Site pulled from GitHub successfully!');
            } else {
                unlink($temp_zip_path);
                return redirect()
                    ->route('sites.show', $site)
                    ->with('error', 'Failed to open downloaded GitHub ZIP archive.');
            }
        } catch (\Illuminate\Http\Client\RequestException $e) {
            $message = 'Failed to pull from GitHub: ' . $e->getMessage();
            if ($e->response->status() === 403 && !$userGitHubToken) {
                $message .= '. This might be a private repository or rate limit exceeded for unauthenticated requests. Please connect your GitHub account via OAuth.';
            }
            return redirect()
                ->route('sites.show', $site)
                ->with(
                    'error', $message
                );
        } catch (\Exception $e) {
            return redirect()
                ->route('sites.show', $site)
                ->with(
                    'error',
                    'An unexpected error occurred: ' . $e->getMessage(),
                );
        }
    }
}
