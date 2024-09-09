<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Подтверждение почты</title>
</head>
<body>
    <div>
        <p>Чтобы подтвердить адрес электронной почты, пожалуйста, кликните по ссылке ниже.</p>
        <a class="btn" target="_blank" href="{{ $url }}">Подтвердить</a>
    </div>
</body>
</html>
