<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'JobBoard') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-100 text-gray-800">

    {{-- Navigation --}}
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('jobs.index') }}" class="text-2xl font-bold text-blue-600">Job<span class="text-gray-800">Board</span></a>

            <div class="space-x-4">
                <a href="{{ route('jobs.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">All Jobs</a>
                {{-- Add auth/links here if needed --}}
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="min-h-screen pt-4 pb-20">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t mt-10">
        <div class="max-w-7xl mx-auto py-6 px-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} JobBoard. All rights reserved.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
