@extends('layouts.user')

@section('content')
<div class="flex min-h-screen bg-slate-50">
    <main class="flex-1 p-10">

        {{-- HEADER --}}
        <div class="flex justify-between items-start mb-10">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-slate-800 uppercase">Dashboard</h1>
                <p class="text-slate-500 font-medium mt-1">
                    Absensi Hari Ini — {{ now()->format('d F Y') }}
                </p>
            </div>
            
            {{-- Welcome Box (Tanpa Foto) --}}
            <div class="px-6 py-3 bg-[#B7CCD4] rounded-lg border border-black/5 shadow-sm">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-600 block mb-1">Pengguna</span>
                <span class="text-slate-900 font-bold text-lg">Welcome, {{ $user->nama }}</span>
            </div>
        </div>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-4 py-3 rounded-r-lg mb-8 shadow-sm">
                <p class="font-bold text-xs uppercase tracking-wider">Berhasil</p>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 px-4 py-3 rounded-r-lg mb-8 shadow-sm">
                <p class="font-bold text-xs uppercase tracking-wider">Perhatian</p>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        @php
            $today = now()->toDateString();
            $absenHariIni = $absensi->where('tanggal', $today)->first();
            $currentShift = $shiftHariIni ?? $user->shift;

            if($currentShift) {
                $sudahMasuk = !empty($absenHariIni?->jam_masuk);
                $sudahPulang = !empty($absenHariIni?->jam_keluar);
                $disableMasuk = $sudahMasuk; 
                $disableKeluar = !$sudahMasuk || $sudahPulang;
            } else {
                $disableMasuk = true;
                $disableKeluar = true;
            }
        @endphp

        {{-- INFO SHIFT & TOMBOL ABSEN --}}
        <div class="mb-12">
            <h2 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Kendali Kehadiran</h2>
            @if($currentShift)
                <div class="bg-white border border-slate-200 p-8 rounded-2xl shadow-sm">
                    <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-black mb-1">Shift Aktif</p>
                            <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tight">{{ $currentShift->nama_shift }}</h3>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-black mb-1">Jadwal Kerja</p>
                            <p class="font-black text-slate-800 text-xl">{{ $currentShift->jam_mulai }} — {{ $currentShift->jam_selesai }}</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <form action="{{ route('user.absen.masuk') }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full py-4 rounded-xl font-black uppercase tracking-[0.15em] text-xs transition-all
                                {{ $disableMasuk ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-lg shadow-emerald-100' }}"
                                {{ $disableMasuk ? 'disabled' : '' }}>
                                {{ $sudahMasuk ? 'Masuk Tercatat' : 'Absen Masuk' }}
                            </button>
                        </form>

                        <form action="{{ route('user.absen.pulang') }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full py-4 rounded-xl font-black uppercase tracking-[0.15em] text-xs transition-all
                                {{ $disableKeluar ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-rose-600 text-white hover:bg-rose-700 shadow-lg shadow-rose-100' }}"
                                {{ $disableKeluar ? 'disabled' : '' }}>
                                {{ $sudahPulang ? 'Pulang Tercatat' : 'Absen Pulang' }}
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-slate-800 p-6 rounded-xl text-white shadow-lg">
                    <p class="font-black uppercase tracking-widest text-[10px] mb-1 opacity-60">Status Jadwal</p>
                    <p class="font-bold">Shift tidak ditemukan. Silakan hubungi Admin untuk verifikasi ID Shift Anda.</p>
                </div>
            @endif
        </div>

        {{-- RINGKASAN IZIN & CUTI --}}
        <div class="mb-12">
            <h2 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Kuota Izin & Cuti</h2>
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm transition-hover hover:border-[#B7CCD4]">
                    <p class="text-slate-400 font-black uppercase text-[10px] tracking-widest mb-2">Sisa Cuti Tahunan</p>
                    <p class="text-4xl font-black text-slate-800">{{ $sisaCuti ?? 0 }} <span class="text-sm font-bold text-slate-300 uppercase tracking-widest">Hari</span></p>
                </div>
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm transition-hover hover:border-[#B7CCD4]">
                    <p class="text-slate-400 font-black uppercase text-[10px] tracking-widest mb-2">Sisa Izin Sakit/Lainnya</p>
                    <p class="text-4xl font-black text-slate-800">{{ $sisaIzin ?? 0 }} <span class="text-sm font-bold text-slate-300 uppercase tracking-widest">Hari</span></p>
                </div>
            </div>
        </div>

        {{-- RIWAYAT ABSENSI --}}
        <div>
            <h2 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Riwayat Aktivitas</h2>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-black">
                            <th class="p-5">Tanggal</th>
                            <th class="p-5">Waktu Presensi</th>
                            <th class="p-5">Status Kehadiran</th>
                            <th class="p-5 text-right">Analisis Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($absensi as $a)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-5 font-bold text-slate-700">
                                    {{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}
                                </td>
                                <td class="p-5">
                                    <div class="text-[11px] font-black space-y-1 uppercase tracking-tight">
                                        <div class="text-emerald-600">Masuk: {{ $a->jam_masuk ?? '--:--' }}</div>
                                        <div class="text-rose-500">Pulang: {{ $a->jam_keluar ?? '--:--' }}</div>
                                    </div>
                                </td>
                                <td class="p-5">
                                    <span class="px-3 py-1 rounded text-[10px] font-black uppercase border tracking-widest
                                    {{ $a->status == 'Hadir' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-rose-50 border-rose-200 text-rose-700' }}">
                                        {{ $a->status }}
                                    </span>
                                </td>
                                <td class="p-5 text-right">
                                    @if($a->terlambat_menit > 0)
                                        <span class="text-[10px] font-black text-rose-500 uppercase">Telat {{ $a->terlambat_menit }} Menit</span>
                                    @elseif($a->lembur_menit > 0)
                                        <span class="text-[10px] font-black text-indigo-500 uppercase">Lembur {{ $a->lembur_menit }} Menit</span>
                                    @else
                                        <span class="text-[10px] font-black text-slate-300 uppercase italic">On-Time</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-16 text-center">
                                    <p class="text-slate-300 text-xs font-black uppercase tracking-[0.3em]">Belum Ada Data Riwayat</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection