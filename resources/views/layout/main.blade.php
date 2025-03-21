<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body class="font-sans bg-gray-100 min-h-screen flex flex-col">
    <header class="bg-white shadow-md py-4">
        @include('partials.header')
    </header>

    <main class="flex-grow container mx-auto px-6 py-8">
        @yield('content')
    </main>
</body>
</html>
