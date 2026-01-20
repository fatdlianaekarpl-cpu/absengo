<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - AbsenGo</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="bg-white">
    <div class="flex">
        <!-- SIDEBAR -->
        @include('components.user.sidebar')

        <!-- CONTENT -->
        <main class="flex-1 p-10">
            @yield('content')
        </main>
    </div>
</body>
</html>
