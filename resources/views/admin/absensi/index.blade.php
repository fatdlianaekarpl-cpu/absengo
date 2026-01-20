@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Absensi Karyawan</h1>
            <p class="text-gray-500">Pantau dan cetak laporan kehadiran harian karyawan.</p>
        </div>
        
        <a href="{{ route('admin.riwayat.pdf', ['bulan' => request('bulan', date('m')), 'tahun' => request('tahun', date('Y'))]) }}" 
           class="flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-red-200">
            <span>📄</span> Cetak Laporan PDF
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <form action="{{ route('admin.riwayat') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Bulan</label>
                <select name="bulan" class="w-full rounded-xl border-gray-200 focus:border-[#B7CCD4] focus:ring focus:ring-[#B7CCD4] focus:ring-opacity-50 text-gray-700">
                    @for ($m=1; $m<=12; $m++)
                        <option value="{{ $m }}" {{ request('bulan', date('m')) == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Tahun</label>
                <select name="tahun" class="w-full rounded-xl border-gray-200 focus:border-[#B7CCD4] focus:ring focus:ring-[#B7CCD4] focus:ring-opacity-50 text-gray-700">
                    @for ($y=date('Y'); $y>=date('Y')-3; $y--)
                        <option value="{{ $y }}" {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="bg-[#B7CCD4] hover:bg-slate-400 text-slate-800 px-6 py-2.5 rounded-xl font-bold transition-all flex items-center gap-2">
                Filter Data
            </button>
        </form>
    </div>

    <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-left uppercase text-xs tracking-wider">
                        <th class="px-6 py-4 font-bold border-b">Tanggal</th>
                        <th class="px-6 py-4 font-bold border-b">Nama Karyawan</th>
                        <th class="px-6 py-4 font-bold border-b">Jam Masuk</th>
                        <th class="px-6 py-4 font-bold border-b">Jam Keluar</th>
                        <th class="px-6 py-4 font-bold border-b text-center">Status</th>
                        <th class="px-6 py-4 font-bold border-b">Detail Waktu</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 divide-y divide-gray-100">
                    @forelse ($riwayat as $item)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700">
                                    {{ $item->user->nama ?? '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg font-semibold border border-blue-100">
                                    {{ $item->jam_masuk ?? '--:--' }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <span class="bg-orange-50 text-orange-700 px-3 py-1.5 rounded-lg font-semibold border border-orange-100">
                                    {{ $item->jam_keluar ?? '--:--' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($item->status === 'Hadir')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold text-[10px] border border-green-200">
                                        TEPAT WAKTU
                                    </span>
                                @elseif ($item->status === 'Terlambat')
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 font-bold text-[10px] border border-red-200">
                                        TERLAMBAT
                                    </span>
                                @elseif ($item->status === 'Lembur')
                                    <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-700 font-bold text-[10px] border border-purple-200">
                                        LEMBUR
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-[10px] border border-gray-200">
                                        {{ strtoupper($item->status) }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if ($item->terlambat_menit > 0)
                                    <div class="flex flex-col mb-1">
                                        <span class="text-red-600 font-bold text-[10px] uppercase">Keterlambatan:</span>
                                        <span class="text-gray-600 text-xs">
                                            {{ floor($item->terlambat_menit / 60) }}j {{ $item->terlambat_menit % 60 }}m
                                        </span>
                                    </div>
                                @endif

                                @if ($item->lembur_menit > 0)
                                    <div class="flex flex-col">
                                        <span class="text-purple-600 font-bold text-[10px] uppercase">Lembur:</span>
                                        <span class="text-gray-600 text-xs">
                                            {{ floor($item->lembur_menit / 60) }}j {{ $item->lembur_menit % 60 }}m
                                        </span>
                                    </div>
                                @endif

                                @if ($item->terlambat_menit == 0 && $item->lembur_menit == 0)
                                    <span class="text-gray-400 italic text-xs">Sesuai Jadwal</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-20">
                                <div class="flex flex-col items-center justify-center opacity-40">
                                    <span class="text-5xl mb-4">🗓️</span>
                                    <p class="text-gray-500 font-medium italic">Belum ada riwayat absensi pada periode ini.</p>
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