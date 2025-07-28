<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $page->title ?: 'Welcome' }} - {{ $page->site->subdomain }}.gimy.site</title>

    {{-- Dynamically load assets linked to this page --}}
    @foreach ($page->assets as $asset)
        @if (Str::endsWith($asset->path, '.css'))
            <link rel="stylesheet" href="{{ $asset->url }}">
        @elseif (Str::endsWith($asset->path, '.js'))
            {{-- JS files are linked at the end of body --}}
        @endif
    @endforeach

    {{-- Important: If you allow users to inject <style> or <script> tags directly in HTML content,
         be aware of XSS risks. Sanitize user input thoroughly or use a strict CSP. --}}
  </head>
  <body>
    {!! $page->html_content !!}

    {{-- Dynamically load JS assets at the end of the body --}}
    @foreach ($page->assets as $asset)
        @if (Str::endsWith($asset->path, '.js'))
            <script src="{{ $asset->url }}"></script>
        @endif
    @endforeach
  </body>
</html>