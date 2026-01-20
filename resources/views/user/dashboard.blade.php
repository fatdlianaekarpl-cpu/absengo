@extends('layouts.user')

@section('content')
<div class="flex">
    <main class="flex-1 p-10">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">
            <div class="px-6 py-2 bg-[#c7d8e1] rounded-xl text-lg font-medium">
                Welcome, {{ $user->nama }}
            </div>
        </div>

        <h1 class="text-3xl font-bold mb-2">Dashboard</h1>
        <p class="text-gray-600 mb-6">
            Absensi Hari Ini ({{ now()->format('d-m-Y') }})
        </p>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-200 text-red-800 p-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- INFO IZIN / CUTI HARI INI --}}
        @if($isIzinHariIni)
            <div class="bg-yellow-200 text-yellow-800 p-3 rounded-lg mb-4">
                Anda sedang <strong>izin / cuti</strong> hari ini, absensi dinonaktifkan.
            </div>
        @endif

        @php
            $today = now()->toDateString();

            // Ambil absen hari ini
            $absenHariIni = $absensi->firstWhere('tanggal', $today);

            if($shiftHariIni) {
                $sudahMasuk = !empty($absenHariIni?->jam_masuk);
                $sudahPulang = !empty($absenHariIni?->jam_keluar);

                // 🔑 PERBAIKAN: BLOK JIKA IZIN / CUTI
                $disableMasuk  = $sudahMasuk || $isIzinHariIni;
                $disableKeluar = !$sudahMasuk || $sudahPulang || $isIzinHariIni;
            } else {
                $disableMasuk = true;
                $disableKeluar = true;
            }
        @endphp

        {{-- SHIFT HARI INI --}}
        @if($shiftHariIni)
            <div class="bg-gray-100 p-4 rounded-lg mb-6">
                <p class="font-semibold">
                    Shift Hari Ini: {{ ucfirst($shiftHariIni->nama_shift) }}
                </p>
                <p>Jam Masuk: {{ $shiftHariIni->jam_mulai }}</p>
                <p>Jam Selesai: {{ $shiftHariIni->jam_selesai }}</p>
            </div>

            {{-- BUTTON MASUK & KELUAR --}}
            <div class="flex gap-4 mb-10">
                <form action="{{ route('user.absen.masuk') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700
                        {{ $disableMasuk ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $disableMasuk ? 'disabled' : '' }}>
                        Masuk
                    </button>
                </form>

                <form action="{{ route('user.absen.pulang') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-gray-600 text-white px-6 py-2 rounded-lg shadow hover:bg-gray-700
                        {{ $disableKeluar ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $disableKeluar ? 'disabled' : '' }}>
                        Keluar
                    </button>
                </form>
            </div>
        @else
            <div class="bg-red-200 text-red-800 p-4 rounded-lg mb-6">
                Tidak ada shift untuk hari ini.
            </div>
        @endif

        {{-- RINGKASAN IZIN & CUTI --}}
        <h2 class="text-xl font-bold mb-4">Ringkasan Izin & Cuti</h2>
        <div class="grid grid-cols-2 gap-4 mb-10">
            <div class="bg-gray-100 p-6 rounded-xl text-center">
                <p class="text-gray-600">Sisa Cuti</p>
                <p class="text-3xl font-bold">{{ $sisaCuti ?? 0 }}</p>
            </div>
            <div class="bg-gray-100 p-6 rounded-xl text-center">
                <p class="text-gray-600">Sisa Izin</p>
                <p class="text-3xl font-bold">{{ $sisaIzin ?? 0 }}</p>
            </div>
        </div>

        {{-- RIWAYAT ABSENSI --}}
        <h2 class="text-xl font-bold mb-4">Riwayat Absensi</h2>
        <table class="w-full border-separate border-spacing-y-2">
            <thead>
                <tr class="text-gray-600">
                    <th>Tanggal</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $a)
                    <tr class="bg-white shadow rounded-xl">
                        <td class="p-4">{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}</td>
                        <td class="p-4">{{ $a->jam_masuk ?? '-' }}</td>
                        <td class="p-4">{{ $a->jam_keluar ?? '-' }}</td>
                        <td class="p-4">
                            <span class="bg-gray-200 px-4 py-1 rounded-lg">
                                {{ ucfirst($a->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">
                            Belum ada absensi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </main>
</div>
@endsection
