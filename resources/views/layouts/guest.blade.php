<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Jadwal Piket') }} — Masuk</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            * { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-10 relative overflow-x-hidden" style="background-color: #FBE6D3;">
        {{-- Background Soft Organic Glows --}}
        <div class="fixed -top-24 -left-24 w-96 h-96 rounded-full blur-3xl opacity-50 pointer-events-none" style="background: #F8D3B4;"></div>
        <div class="fixed -bottom-24 -right-24 w-[32rem] h-[32rem] rounded-full blur-3xl opacity-60 pointer-events-none" style="background: #F8D0B0;"></div>

        <div class="w-full flex items-center justify-center relative z-10">
            {{ $slot }}
        </div>
    </body>
</html>
