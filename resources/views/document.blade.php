<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $document->name }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.ts'])
</head>
<body class="h-full">
<div>
    <h3 class="text-center py-2">{{ $document->name }}</h3>
    <main class="px-4 pb-4">
        {!! nl2br($document->text) !!}
    </main>
</div>
</body>
</html>
