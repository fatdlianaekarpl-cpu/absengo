@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-8">Dashboard</h1>

<div class="grid grid-cols-3 gap-10">

    <div class="bg-white shadow rounded-xl p-6">
        <p class="text-gray-500">Total Karyawan</p>
        <p class="text-3xl font-bold mt-2">120</p>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
        <p class="text-gray-500">Karyawan Aktif</p>
        <p class="text-3xl font-bold mt-2">110</p>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
        <p class="text-gray-500">Karyawan Izin & Cuti</p>
        <p class="text-3xl font-bold mt-2">10</p>
    </div>

</div>

@endsection
