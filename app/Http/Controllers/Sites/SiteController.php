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
      // Simple JavaScript to log a message when the page loads
      document.addEventListener("DOMContentLoaded", () => {
        console.log("Welcome to Gimy.site - Your site is live!");
      });
    </script>
  </body>
</html>
';
        $default_site->save();

        Storage::disk('sites')->put($default_site->path, $default_site->content);

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

    public function pull(Site $site)
    {
        $this->authorize('update', $site);

        if (!$site->github_url) {
            return redirect()
                ->route('sites.show', $site)
                ->with('error', 'No GitHub URL configured for this site.');
        }

        $github_url_parts = explode('/', $site->github_url);
        $owner = $github_url_parts[3];
        $repo = Str::of($github_url_parts[4])->replace('.git', '');

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/vnd.github.v3+json',
                'Authorization' => 'token ' . config('services.github.token'),
            ])->get("https://api.github.com/repos/{$owner}/{$repo}/contents");

            $response->throw();

            $contents = $response->json();

            Storage::disk('sites')->deleteDirectory($site->id);
            Storage::disk('sites')->makeDirectory($site->id);
            $site->files()->delete();

            foreach ($contents as $item) {
                if ($item['type'] === 'file') {
                    $file_content_response = Http::withHeaders([
                        'Accept' => 'application/vnd.github.v3.raw',
                        'Authorization' =>
                            'token ' . config('services.github.token'),
                    ])->get($item['download_url']);

                    $file_content_response->throw();

                    $file_path = $site->id . '/' . $item['path'];
                    Storage::disk('sites')->put(
                        $file_path,
                        $file_content_response->body(),
                    );

                    $siteFile = new SiteFile();
                    $siteFile->site_id = $site->id;
                    $siteFile->path = $file_path;
                    $siteFile->content = $file_content_response->body();
                    $siteFile->save();
                } elseif ($item['type'] === 'dir') {
                    Storage::disk('sites')->makeDirectory(
                        $site->id . '/' . $item['path'],
                    );
                }
            }

            return redirect()
                ->route('sites.show', $site)
                ->with('status', 'Site pulled from GitHub successfully!');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return redirect()
                ->route('sites.show', $site)
                ->with(
                    'error',
                    'Failed to pull from GitHub: ' . $e->getMessage(),
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