@extends('layouts.user')

@section('content')

<h1 class="text-2xl font-bold mb-6">Ajukan Izin & Cuti</h1>

{{-- INFORMASI JATAH (TAMBAHAN) --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-xl shadow-sm">
        <p class="text-blue-700 text-sm font-semibold uppercase tracking-wider">Sisa Jatah Cuti</p>
        <p class="text-3xl font-bold text-blue-900">{{ Auth::user()->sisa_cuti }} <span class="text-sm font-normal text-blue-700">Hari</span></p>
    </div>
    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm">
        <p class="text-emerald-700 text-sm font-semibold uppercase tracking-wider">Sisa Jatah Izin</p>
        <p class="text-3xl font-bold text-emerald-900">{{ Auth::user()->sisa_izin }} <span class="text-sm font-normal text-emerald-700">Hari</span></p>
    </div>
</div>

<div class="flex gap-3 mb-6">
    <a href="{{ route('user.dashboard') }}"
       class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition text-sm font-medium">
        ← Kembali ke Dashboard
    </a>
</div>

{{-- NOTIFIKASI SUCCESS/ERROR --}}
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('user.izin-cuti.store') }}"
      method="POST"
      class="space-y-4 max-w-xl bg-white p-6 rounded-xl shadow-lg border border-gray-100">
    @csrf

    <div>
        <label class="block text-sm font-semibold mb-2">Pilih Jenis Pengajuan</label>
        <select name="jenis" required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">-- Pilih --</option>
            <option value="Izin" {{ Auth::user()->sisa_izin <= 0 ? 'disabled' : '' }}>Izin (Sisa: {{ Auth::user()->sisa_izin }})</option>
            <option value="Cuti" {{ Auth::user()->sisa_cuti <= 0 ? 'disabled' : '' }}>Cuti (Sisa: {{ Auth::user()->sisa_cuti }})</option>
        </select>
        @if(Auth::user()->sisa_cuti <= 0 && Auth::user()->sisa_izin <= 0)
            <p class="text-red-500 text-xs mt-2 italic">* Jatah Anda sudah habis, tidak bisa mengajukan baru.</p>
        @endif
    </div>

    <div>
        <label class="block text-sm font-semibold mb-2">Alasan</label>
        <textarea name="alasan" required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none min-h-[100px]"
            placeholder="Contoh: Sakit, Kepentingan keluarga, dll"></textarea>
    </div>

    <div class="flex flex-col md:flex-row gap-4">
        <div class="w-full">
            <label class="block text-sm font-semibold mb-2">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        <div class="w-full">
            <label class="block text-sm font-semibold mb-2">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
    </div>

    <div class="flex gap-3 pt-6">
        <button type="submit"
            class="bg-blue-600 text-white px-8 py-2 rounded-lg hover:bg-blue-700 transition font-bold disabled:opacity-50 disabled:cursor-not-allowed"
            {{ (Auth::user()->sisa_cuti <= 0 && Auth::user()->sisa_izin <= 0) ? 'disabled' : '' }}>
            Ajukan Sekarang
        </button>

        <button type="reset"
            class="bg-gray-100 text-gray-600 px-6 py-2 rounded-lg hover:bg-gray-200 transition font-medium">
            Reset
        </button>
    </div>
</form>

@endsection