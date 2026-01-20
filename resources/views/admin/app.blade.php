<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'AbsenGo' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-10">
        <!-- Header -->
        <div class="flex justify-end items-center gap-4 mb-10">
            <span class="bg-[#B7CCD4] px-6 py-2 rounded-lg font-medium">
                Welcome Admin
            </span>
            <img src="{{ asset('image/eko.jpeg') }}"
                 class="w-12 h-12 rounded-full ml-4 object-cover">
        </div>

        <!-- Page Content -->
        @yield('content')

    </main>

</div>

</body>
</html>
