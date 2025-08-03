<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ViewController extends Controller
{
    public function show(Request $request, Site $site, string $path = 'index.html')
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
            $baseUrl = route('sites.preview', ['site' => $site->id, 'path' => ''], false).'/';
            
            $fileContent = preg_replace_callback(
                '/(src|href|url)\s*=\s*(["\'])(?!https?:\/\/)(?!data:)(?!#)(?!{{)(?!`)(.*?)\2/i',
                function ($matches) use ($baseUrl) {
                    $attribute = $matches[1];
                    $quote = $matches[2];
                    $relativePath = $matches[3];

                    if (str_starts_with($relativePath, '/')) {
                        return "{$attribute}={$quote}{$baseUrl}" . ltrim($relativePath, '/') . $quote;
                    }

                    return "{$attribute}={$quote}{$baseUrl}" . $relativePath . $quote;
                },
                $fileContent
            );
        }

        return response($fileContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }
}