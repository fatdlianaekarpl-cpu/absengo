<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | AbsenGo</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="bg-[#F4F6FB] flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-6">

        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="bg-[#3B82F6] w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-200">
                <i class="bi bi-person-check-fill text-white text-3xl"></i>
            </div>

            <h2 class="text-3xl font-bold text-gray-900">
                Absen<span class="text-[#3B82F6]">Go</span>
            </h2>
            <p class="text-gray-500 mt-2">Login AbsenGo</p>
        </div>

        <!-- Card -->
        <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100">

            <form method="POST" action="/login">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="block w-full pl-10 pr-4 py-3 bg-gray-100 border border-gray-200 rounded-xl
                                      focus:ring-2 focus:ring-[#3B82F6] focus:border-[#3B82F6]
                                      outline-none transition-all text-gray-700"
                               placeholder="nama@email.com" required autofocus>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password"
                               class="block w-full pl-10 pr-4 py-3 bg-gray-100 border border-gray-200 rounded-xl
                                      focus:ring-2 focus:ring-[#3B82F6] focus:border-[#3B82F6]
                                      outline-none transition-all text-gray-700"
                               placeholder="••••••••" required>
                    </div>
                </div>

                <!-- Error -->
                @error('email')
                    <div class="flex items-center gap-2 text-red-600 text-sm mb-4 p-3 bg-red-50 rounded-lg border border-red-100">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <p>{{ $message }}</p>
                    </div>
                @enderror

                <!-- Button -->
                <button type="submit"
                        class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-xl transition-all active:scale-[0.98]">
                    Login
                </button>
            </form>
        </div>


    </div>

</body>
</html>
