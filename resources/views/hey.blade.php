<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" id="app">
<div class="min-h-screen bg-[#F3EEEA] pt-20 px-40">
    <div class="grid grid-cols-12 gap-x-5 h-[650px]">
        <div class="col-span-3 shadow rounded h-full bg-[#EBE3D5] p-5 bg-opacity-50">
            foo
        </div>
        <div class="col-span-9 shadow rounded h-full bg-[#EBE3D5] p-5">
            bar
        </div>
    </div>
</div>
</body>
</html>
