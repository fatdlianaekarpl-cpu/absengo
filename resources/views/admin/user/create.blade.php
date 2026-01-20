@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="p-10">
    <div class="max-w-2xl bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Karyawan Baru</h1>

        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama --}}
                <div class="mb-4">
                    <label class="block mb-2 font-semibold text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Masukkan nama"
                           value="{{ old('nama') }}"
                           required>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block mb-2 font-semibold text-gray-700">Email</label>
                    <input type="email" name="email"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="email@perusahaan.com"
                           value="{{ old('email') }}"
                           required>
                </div>

                {{-- Department --}}
                <div class="mb-4">
                    <label class="block mb-2 font-semibold text-gray-700">Department</label>
                    <input type="text" name="department"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="HRD / IT / Finance"
                           value="{{ old('department') }}"
                           required>
                </div>

                {{-- Status --}}
                <div class="mb-4">
                    <label class="block mb-2 font-semibold text-gray-700">Status</label>
                    <select name="status"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                            required>
                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Password --}}
                <div class="mb-4 md:col-span-2">
                    <label class="block mb-2 font-semibold text-gray-700">Password</label>
                    <input type="password" name="password"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Minimal 6 karakter"
                           required>
                </div>

                <hr class="md:col-span-2 my-2 border-gray-100">

                {{-- Sisa Cuti --}}
                <div class="mb-4">
                    <label class="block mb-2 font-semibold text-blue-600">Jatah Cuti (Tahunan)</label>
                    <input type="number" name="sisa_cuti"
                           class="w-full border border-blue-100 bg-blue-50/30 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Contoh: 12"
                           value="{{ old('sisa_cuti', 12) }}"
                           required>
                </div>

                {{-- Sisa Izin --}}
                <div class="mb-4">
                    <label class="block mb-2 font-semibold text-green-600">Jatah Izin (Darurat)</label>
                    <input type="number" name="sisa_izin"
                           class="w-full border border-green-100 bg-green-50/30 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-500 outline-none"
                           placeholder="Contoh: 5"
                           value="{{ old('sisa_izin', 5) }}"
                           required>
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                    Simpan Karyawan
                </button>
                <a href="{{ route('admin.user.index') }}"
                   class="px-8 py-3 border border-gray-200 text-gray-500 rounded-xl font-bold hover:bg-gray-50 transition text-center">
                    Batal
                </a>
            </div>
        </form>

        @if ($errors->any())
            <div class="mt-6 p-4 bg-red-50 border border-red-100 rounded-xl">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection