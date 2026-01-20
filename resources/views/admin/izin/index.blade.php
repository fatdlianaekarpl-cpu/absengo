@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Izin & Cuti</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola, setujui, atau tolak pengajuan ketidakhadiran karyawan.</p>
        </div>
        
        {{-- Tombol Cetak PDF --}}
        <a href="{{ route('admin.izin.pdf', request()->all()) }}" 
           class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-red-100">
            <span>📄</span> Cetak Rekap PDF
        </a>
    </div>

    {{-- Notifikasi Flash Message --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-r-xl mb-6 shadow-sm flex items-center gap-3">
            <span class="text-xl">✅</span>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded-r-xl mb-6 shadow-sm flex items-center gap-3">
            <span class="text-xl">⚠️</span>
            <p class="font-medium">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Filter & Search Bar --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6">
        <form method="GET" action="{{ route('admin.izin.index') }}" class="flex flex-col md:flex-row gap-4">
            {{-- Input Search --}}
            <div class="relative flex-grow">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari nama karyawan..." 
                       class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#B7CCD4] focus:border-[#B7CCD4] outline-none transition-all">
            </div>

            {{-- Hidden Status (agar saat search, filter status tetap terbawa) --}}
            <input type="hidden" name="status" value="{{ request('status', 'semua') }}">

            <button type="submit" class="bg-slate-800 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-slate-700 transition">
                Cari Data
            </button>
            
            @if(request('search') || request('status'))
                <a href="{{ route('admin.izin.index') }}" class="flex items-center justify-center px-4 text-gray-500 hover:text-red-500 font-medium transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Status Tabs Navigation --}}
    @php $currentStatus = request('status', 'semua'); @endphp
    <div class="flex gap-2 border-b border-gray-200 mb-6 overflow-x-auto no-scrollbar">
        @foreach (['semua', 'menunggu', 'disetujui', 'ditolak'] as $tab)
            <a href="{{ route('admin.izin.index', array_merge(request()->query(), ['status' => $tab])) }}" 
               class="pb-3 px-6 text-sm font-bold transition-all border-b-2 whitespace-nowrap
               {{ $currentStatus === $tab ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-400 hover:text-gray-600' }}">
                {{ ucfirst($tab) }}
            </a>
        @endforeach
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase">Karyawan</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase text-center">Jenis</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase">Sisa Jatah</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase">Periode</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase">Alasan</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase text-center">Status</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse ($izin as $item)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-4 px-6">
                                <div class="font-bold text-gray-800">{{ $item->user->nama ?? '-' }}</div>
                                <div class="text-[10px] text-gray-400 font-medium uppercase">{{ $item->user->department ?? 'General' }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold 
                                    {{ $item->jenis === 'Cuti' ? 'bg-purple-50 text-purple-600 border border-purple-100' : 'bg-orange-50 text-orange-600 border border-orange-100' }}">
                                    {{ strtoupper($item->jenis) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-xs font-semibold {{ ($item->jenis === 'Cuti' ? ($item->user->sisa_cuti ?? 0) : ($item->user->sisa_izin ?? 0)) <= 0 ? 'text-red-500' : 'text-slate-600' }}">
                                    @if($item->jenis === 'Cuti')
                                        Cuti: {{ $item->user->sisa_cuti ?? 0 }} Hari
                                    @else
                                        Izin: {{ $item->user->sisa_izin ?? 0 }} Hari
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-xs text-gray-700 font-bold">
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-xs text-gray-500 max-w-[150px] truncate" title="{{ $item->alasan }}">
                                    {{ $item->alasan }}
                                </p>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($item->status === 'disetujui')
                                    <span class="text-green-600 font-bold text-[10px] bg-green-50 px-2 py-1 rounded border border-green-100 uppercase">Disetujui</span>
                                @elseif($item->status === 'menunggu')
                                    <span class="text-yellow-600 font-bold text-[10px] bg-yellow-50 px-2 py-1 rounded border border-yellow-100 uppercase animate-pulse">Menunggu</span>
                                @else
                                    <span class="text-red-600 font-bold text-[10px] bg-red-50 px-2 py-1 rounded border border-red-100 uppercase">Ditolak</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($item->status === 'menunggu')
                                    <div class="flex justify-center gap-2">
                                        @php
                                            $jatahHabis = ($item->jenis === 'Cuti' && ($item->user->sisa_cuti ?? 0) <= 0) || 
                                                          ($item->jenis === 'Izin' && ($item->user->sisa_izin ?? 0) <= 0);
                                        @endphp
                                        
                                        <form action="{{ route('admin.izin.approve', $item->id) }}" method="POST" onsubmit="return confirm('Setujui pengajuan ini?')">
                                            @csrf
                                            <button type="submit" 
                                                class="bg-green-600 text-white px-3 py-1.5 rounded-lg text-[10px] font-bold hover:bg-green-700 transition disabled:opacity-50"
                                                {{ $jatahHabis ? 'disabled' : '' }}>
                                                {{ $jatahHabis ? 'HABIS' : 'APPROVE' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.izin.reject', $item->id) }}" method="POST" onsubmit="return confirm('Tolak pengajuan ini?')">
                                            @csrf
                                            <button type="submit" 
                                                class="bg-white border border-red-200 text-red-600 px-3 py-1.5 rounded-lg text-[10px] font-bold hover:bg-red-50 transition">
                                                REJECT
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center text-[10px] text-gray-300 font-bold uppercase italic">Processed</div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-20">
                                <div class="opacity-30 flex flex-col items-center">
                                    <span class="text-5xl mb-4">📂</span>
                                    <p class="font-bold text-gray-500">Tidak ada pengajuan ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection