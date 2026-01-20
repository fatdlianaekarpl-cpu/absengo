<aside class="w-72 bg-[#B7CCD4] p-8 flex flex-col justify-between min-h-screen">

    <div>
        <!-- Logo -->
        <div class="text-3xl font-bold mb-12 flex items-center gap-2">
            <span>⚡</span> AbsenGo
        </div>

        <!-- Menu -->
        <nav class="space-y-4">

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 p-3 rounded-lg font-semibold
                {{ request()->routeIs('admin.dashboard') ? 'bg-white' : 'hover:bg-white' }}">
                🏠 Dashboard
            </a>


            <!-- Manajemen Izin & Cuti -->
            <a href="{{ route('admin.izin.index') }}"
                class="flex items-center gap-3 p-3 rounded-lg font-semibold
                {{ request()->routeIs('admin.izin.*') ? 'bg-white' : 'hover:bg-white' }}">
                📅 Manajemen Izin & Cuti
            </a>

            <!-- Shift -->
            <a href="{{ route('admin.shift.index') }}" 
                class="flex items-center gap-3 p-3 rounded-lg font-semibold 
                {{ request()->routeIs('admin.shift.*') ? 'bg-white' : 'hover:bg-white' }}">
                🕒 Manajemen Shift
            </a>

            <!-- Data User -->
            <a href="{{ route('admin.user.index') }}"
                class="flex items-center gap-3 p-3 rounded-lg font-semibold
                {{ request()->routeIs('admin.user.*') ? 'bg-white' : 'hover:bg-white' }}">
                👤 Data User
            </a>
        </nav>
    </div>

    <!-- Logout -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
            class="w-full text-left flex items-center gap-3 p-3 hover:bg-white rounded-lg text-red-600 font-medium">
            ↩ Logout
        </button>
    </form>

</aside>
