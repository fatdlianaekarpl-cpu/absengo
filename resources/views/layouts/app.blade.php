<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'AbsenGo' }}</title>

    {{-- TAILWIND --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- BOOTSTRAP CSS (WAJIB UNTUK TABLE, MODAL, BTN) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- ALPINE JS --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main Content --}}
    <main class="flex-1 p-10">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-2xl font-bold">
                @yield('title')
            </h1>

            <div class="flex items-center gap-4">
                <span class="bg-[#B7CCD4] px-6 py-2 rounded-lg font-medium">
                    Welcome {{ auth()->user()->nama ?? 'Admin' }}
                </span>
            </div>
        </div>

        {{-- Page Content --}}
        @yield('content')

    </main>

</div>

{{-- BOOTSTRAP JS (INI KUNCI MODAL) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
