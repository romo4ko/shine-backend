<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Подтверждение почты</title>
</head>
<body class="h-full">
    <div class="px-4 pb-4">
        <h1>
            {{ $status['title'] }}
        </h1>
        <p>
            {{ $status['description'] }}
        </p>
    </div>
</body>
</html>

