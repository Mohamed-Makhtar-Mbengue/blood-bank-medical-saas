<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Blood Bank') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-black flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-gray-900/70 backdrop-blur-xl border border-red-600/20 shadow-2xl rounded-2xl p-10">
        {{ $slot }}
    </div>
</body>

</html>
