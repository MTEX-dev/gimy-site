<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\SiteFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Auth::user()->sites;
        return view('sites.index', compact('sites'));
    }

    public function create()
    {
        return view('sites.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'domain' => 'nullable|string|max:255|unique:sites',
            'github_url' => 'nullable|string|max:255',
        ]);

        $site = Auth::user()->sites()->create($request->all());

        Storage::disk('sites')->makeDirectory($site->id);

        $default_site = new SiteFile();

        $default_site->site_id = $site->id;
        $default_site->path = 'index.html';
        $default_site->content = '
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to Gimy.site!</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        background-color: #f4f4f4;
        color: #333;
        text-align: center;
      }
      .container {
        background-color: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        animation: fadeIn 1s ease-out;
      }
      h1 {
        color: #007bff;
        margin-bottom: 20px;
      }
      p {
        font-size: 1.1em;
        line-height: 1.6;
      }
      a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
      }
      a:hover {
        text-decoration: underline;
      }
      .footer-text {
        margin-top: 30px;
        font-size: 0.9em;
        color: #777;
      }
      @keyframes fadeIn {
        from {
          opacity: 0;
          transform: translateY(-20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h1>Hello there!</h1>
      <p>
        This is the default site, automatically generated for your new project
        on
        <a href="https://gimy.site" target="_blank">gimy.site</a>.
      </p>
      <p>
        Gimy.site is your go-to for a free and easy website hosting experience,
        fully supporting HTML, CSS, and JavaScript. Get ready to bring your
        ideas to life!
      </p>
      <p class="footer-text">
        Start building your amazing website today!
      </p>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        console.log("Welcome to Gimy.site - Your site is live!");
      });
    </script>
  </body>
</html>
';
        $default_site->save();

        Storage::disk('sites')->put($site->id . '/' . $default_site->path, $default_site->content);

        return redirect()->route('sites.show', $site);
    }

    public function show(Site $site)
    {
        $this->authorize('view', $site);
        return view('sites.show', compact('site'));
    }

    public function edit(Site $site)
    {
        $this->authorize('update', $site);
        return view('sites.edit', compact('site'));
    }

    public function update(Request $request, Site $site)
    {
        $this->authorize('update', $site);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'domain' =>
                'nullable|string|max:255|unique:sites,domain,' . $site->id,
            'github_url' => 'nullable|string|max:255',
        ]);

        $site->update($request->all());

        return redirect()->route('sites.show', $site);
    }

    public function destroy(Site $site)
    {
        $this->authorize('delete', $site);
        Storage::disk('sites')->deleteDirectory($site->id);
        $site->delete();
        return redirect()->route('sites.index');
    }

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
                $site->files()->delete();

                $extract_path = Storage::disk('sites')->path($site->id);
                $zip->extractTo($extract_path);
                $zip->close();

                unlink($temp_zip_path);

                $extracted_repo_folder = glob($extract_path . '/*', GLOB_ONLYDIR)[0] ?? null;

                if ($extracted_repo_folder) {
                    foreach (
                        new \RecursiveIteratorIterator(
                            new \RecursiveDirectoryIterator($extracted_repo_folder, \RecursiveDirectoryIterator::SKIP_DOTS),
                            \RecursiveIteratorIterator::SELF_FIRST
                        ) as $item
                    ) {
                        $relative_path = Str::replaceFirst($extracted_repo_folder . '/', '', $item->getPathname());
                        $destination_path = $site->id . '/' . $relative_path;

                        if ($item->isFile()) {
                            Storage::disk('sites')->put($destination_path, file_get_contents($item->getPathname()));

                            $siteFile = new SiteFile();
                            $siteFile->site_id = $site->id;
                            $siteFile->path = $destination_path;
                            $siteFile->content = file_get_contents($item->getPathname());
                            $siteFile->save();
                        } elseif ($item->isDir()) {
                            Storage::disk('sites')->makeDirectory($destination_path);
                        }
                    }
                    Storage::disk('sites')->deleteDirectory(Str::afterLast($extracted_repo_folder, '/'));
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