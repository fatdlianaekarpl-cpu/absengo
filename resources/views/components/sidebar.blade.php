<aside class="w-72 bg-[#B7CCD4] flex flex-col min-h-screen border-r border-black/5">
    <div class="p-8">
        <div class="mb-12 px-2">
            <h1 class="text-2xl font-black tracking-tighter text-slate-800 uppercase">
                AbsenGo
            </h1>
        </div>

        <nav class="space-y-1">
            <a href="{{ route('admin.dashboard') }}"
                class="block w-full px-4 py-3 rounded-md transition-all duration-200
                {{ request()->routeIs('admin.dashboard') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-700 hover:bg-white/40' }}">
                <span class="text-sm font-bold uppercase tracking-wide">Dashboard</span>
            </a>

            <a href="{{ route('admin.riwayat') }}"
                class="block w-full px-4 py-3 rounded-md transition-all duration-200
                {{ request()->routeIs('admin.riwayat') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-700 hover:bg-white/40' }}">
                <span class="text-sm font-bold uppercase tracking-wide">Riwayat Absensi</span>
            </a>

            <a href="{{ route('admin.izin.index') }}"
                class="block w-full px-4 py-3 rounded-md transition-all duration-200
                {{ request()->routeIs('admin.izin.*') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-700 hover:bg-white/40' }}">
                <span class="text-sm font-bold uppercase tracking-wide">Izin & Cuti</span>
            </a>

            <a href="{{ route('admin.shift.index') }}" 
                class="block w-full px-4 py-3 rounded-md transition-all duration-200
                {{ request()->routeIs('admin.shift.*') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-700 hover:bg-white/40' }}">
                <span class="text-sm font-bold uppercase tracking-wide">Manajemen Shift</span>
            </a>

            <a href="{{ route('admin.user.index') }}"
                class="block w-full px-4 py-3 rounded-md transition-all duration-200
                {{ request()->routeIs('admin.user.*') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-700 hover:bg-white/40' }}">
                <span class="text-sm font-bold uppercase tracking-wide">Data User</span>
            </a>
        </nav>
    </div>

    <div class="mt-auto p-8 border-t border-black/5">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="group flex items-center gap-2 text-red-600 font-bold hover:opacity-70 transition-opacity">
                <span class="text-sm uppercase tracking-widest">Logout</span>
                <span class="text-lg">→</span>
            </button>
        </form>
    </div>
</aside>