@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-8">Dashboard</h1>

<div class="grid grid-cols-4 gap-10">

    <div class="bg-white shadow rounded-xl p-6">
        <p class="text-gray-500">Total Karyawan</p>
        <p class="text-3xl font-bold mt-2">{{ $totalKaryawan }}</p>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
        <p class="text-gray-500">Karyawan Aktif</p>
        <p class="text-3xl font-bold mt-2">{{ $karyawanAktif }}</p>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
        <p class="text-gray-500">Karyawan Tidak Aktif</p>
        <p class="text-3xl font-bold mt-2 text-red-600">{{ $karyawanTidakAktif }}</p>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
        <p class="text-gray-500">Karyawan Izin & Cuti</p>
        <p class="text-3xl font-bold mt-2">{{ $karyawanIzin }}</p>
    </div>

</div>

@endsection
