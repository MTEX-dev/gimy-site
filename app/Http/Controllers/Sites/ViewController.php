<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Site;
use App\Models\SiteView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ViewController extends Controller
{
    public function preview(Request $request, Site $site, string $path = 'index.html')
    {


        $disk = Storage::disk('sites');
        $siteDirectory = $site->id;

        $filePath = $siteDirectory . '/' . $path;

        $filePath = str_replace(['..\\', '../'], '', $filePath);

        if (!$disk->exists($filePath)) {
            if (str_contains($path, '.')) {
                abort(404, 'File not found');
            }

            $filePathIndex = $filePath . '/index.html';
            if ($disk->exists($filePathIndex)) {
                $filePath = $filePathIndex;
            } else {
                abort(404, 'Page or file not found');
            }
        }

        $fileContent = $disk->get($filePath);

        $mimeType = $disk->mimeType($filePath);

        if (str_contains($mimeType, 'text/html')) {
            $baseUrl = route('sites.preview', ['site' => $site->id, 'path' => ''], false) . '/';

            $fileContent = preg_replace_callback(
                '/(src|href|url)\s*=\s*(["\'])(?!https?:\/\/)(?!data:)(?!#)(?!{{)(?!`)(.*?)\2/i',
                function ($matches) use ($baseUrl) {
                    $attribute = $matches[1];
                    $quote = $matches[2];
                    $relativePath = $matches[3];

                    if (str_starts_with($relativePath, '/')) {
                        return "{$attribute}={$quote}{$baseUrl}" .
                            ltrim($relativePath, '/') .
                            $quote;
                    }

                    return "{$attribute}={$quote}{$baseUrl}" . $relativePath . $quote;
                },
                $fileContent,
            );
        }

        return response($fileContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }

    public function show(Request $request, Site $site, string $path = 'index.html')
    {
        $this->recordView($request, $site);

        $disk = Storage::disk('sites');
        $siteDirectory = $site->id;

        $filePath = $siteDirectory . '/' . $path;

        $filePath = str_replace(['..\\', '../'], '', $filePath);

        if (!$disk->exists($filePath)) {
            if (str_contains($path, '.')) {
                abort(404, 'File not found');
            }

            $filePathIndex = $filePath . '/index.html';
            if ($disk->exists($filePathIndex)) {
                $filePath = $filePathIndex;
            } else {
                abort(404, 'Page or file not found');
            }
        }

        $fileContent = $disk->get($filePath);

        $mimeType = $disk->mimeType($filePath);

        if (str_contains($mimeType, 'text/html')) {
            $baseUrl = route('sites.preview', ['site' => $site->id, 'path' => ''], false) . '/';

            $fileContent = preg_replace_callback(
                '/(src|href|url)\s*=\s*(["\\])(?!https?:\/\/)(?!data:)(?!#)(?!{{)(?!`)(.*?)\2/i',
                function ($matches) use ($baseUrl) {
                    $attribute = $matches[1];
                    $quote = $matches[2];
                    $relativePath = $matches[3];

                    if (str_starts_with($relativePath, '/')) {
                        return "{$attribute}={$quote}{$baseUrl}" .
                            ltrim($relativePath, '/') .
                            $quote;
                    }

                    return "{$attribute}={$quote}{$baseUrl}" . $relativePath . $quote;
                },
                $fileContent,
            );
        }

        return response($fileContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }

    protected function recordView(Request $request, Site $site)
    {
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $route = $request->path();

        if (!str_contains($request->header('Accept', ''), 'text/html')) {
            return;
        }

        $device = Device::firstOrNew(['ip_address' => $ipAddress]);
        $device->user_agent = $userAgent;
        $device->save();

        $lastView = SiteView::where('site_id', $site->id)
            ->where('device_id', $device->id)
            ->latest('viewed_at')
            ->first();

        if ($lastView && $lastView->viewed_at->diffInMinutes(now()) < 5) {
            return;
        }

        SiteView::create([
            'site_id' => $site->id,
            'device_id' => $device->id,
            'route' => $route,
            'viewed_at' => now(),
        ]);
    }
}