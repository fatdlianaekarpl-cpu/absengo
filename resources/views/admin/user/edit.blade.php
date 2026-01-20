@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-4">Edit User</h2>

    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama</label>
            <input type="text" name="nama"
                value="{{ old('nama', $user->nama) }}"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email"
                value="{{ old('email', $user->email) }}"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        {{-- Pilih Shift (PENTING!) --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-blue-600">Shift Kerja</label>
            <select name="shift_id" class="w-full border rounded-lg px-3 py-2 border-blue-300 bg-blue-50 focus:ring-2 focus:ring-blue-500 outline-none">
                <option value="">-- Pilih Shift Tetap --</option>
                @foreach($shifts as $shift)
                    <option value="{{ $shift->id }}" {{ $user->shift_id == $shift->id ? 'selected' : '' }}>
                        {{ $shift->nama_shift }} ({{ $shift->jam_mulai }} - {{ $shift->jam_selesai }})
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">*User tidak bisa absen jika shift tidak dipilih.</p>
        </div>

        {{-- Row untuk Cuti & Izin --}}
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1 font-semibold">Sisa Cuti (Hari)</label>
                <input type="number" name="sisa_cuti"
                    value="{{ old('sisa_cuti', $user->sisa_cuti) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Sisa Izin (Hari)</label>
                <input type="number" name="sisa_izin"
                    value="{{ old('sisa_izin', $user->sisa_izin) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
        </div>

        {{-- Department --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Department</label>
            <input type="text" name="department"
                value="{{ old('department', $user->department) }}"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        {{-- Status --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Status Akun</label>
            <select name="status" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                <option value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ $user->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-red-600">
                Ganti Password <span class="text-xs text-gray-500 font-normal">(kosongkan jika tidak ingin diubah)</span>
            </label>
            <input type="password" name="password"
                class="w-full border border-red-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 outline-none">
        </div>

        {{-- Button --}}
        <div class="flex justify-end gap-2 pt-4 border-t">
            <a href="{{ route('admin.user.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                Batal
            </a>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md transition">
                Update Data User
            </button>
        </div>

    </form>
</div>
@endsection