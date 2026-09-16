@props([
    'title' => 'Jara - Collaborative Task Management Platform',
    'containerClass' => 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full',
    'fullWidth' => false,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 text-slate-900 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <!-- Google / Bunny Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen bg-slate-50 text-slate-900 font-sans selection:bg-indigo-500 selection:text-white">
    <!-- Navbar -->
    <x-navbar />

    <!-- Main Content Area -->
    <main class="flex-1 w-full flex flex-col">
        @if ($fullWidth)
            <div class="w-full flex-1 flex flex-col">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <x-alert />
                </div>
                {{ $slot }}
            </div>
        @else
            <div class="{{ $containerClass }} flex-1">
                <!-- Global Flash / Error Alerts -->
                <x-alert />

                <!-- Page Content -->
                {{ $slot }}
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="mt-auto border-t border-slate-200 bg-white py-6 text-center text-sm text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center h-6 w-6 rounded-md bg-indigo-600 text-white text-xs font-bold shadow-sm">
                    J
                </span>
                <span class="font-semibold text-slate-700">Jara</span>
                <span class="text-xs text-slate-400">&copy; {{ date('Y') }} Collaborative Platform</span>
            </div>
            <div class="flex items-center gap-6 text-xs text-slate-500">
                <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors">Beranda</a>
                <a href="{{ route('projects.index') }}" class="hover:text-indigo-600 transition-colors">Proyek</a>
                <a href="{{ route('admin.index') }}" class="hover:text-indigo-600 transition-colors">Admin</a>
            </div>
        </div>
    </footer>
</body>
</html>
