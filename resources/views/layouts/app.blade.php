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

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <style>
            .btn-primary { @apply px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition; }
            .btn-success { @apply px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition; }
            .btn-danger { @apply px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition; }
            .btn-warning { @apply px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition; }
            .btn-info { @apply px-4 py-2 bg-cyan-500 text-white rounded hover:bg-cyan-600 transition; }
            .btn-purple { @apply px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600 transition; }
            .btn-pink { @apply px-4 py-2 bg-pink-500 text-white rounded hover:bg-pink-600 transition; }
            .btn-gray { @apply px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
