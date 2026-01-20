@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <div class="max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="bi bi-clock-history text-blue-600"></i> Manajemen Shift Kerja
        </h1>

        {{-- FORM TAMBAH SHIFT --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
            <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Tambah Shift Baru</h2>
            <form action="{{ route('admin.shift.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs text-gray-400 ml-1">Nama Shift</label>
                        <input type="text" name="nama_shift" placeholder="Contoh: Pagi"
                            class="border border-gray-200 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs text-gray-400 ml-1">Jam Mulai</label>
                        <input type="time" name="jam_mulai"
                            class="border border-gray-200 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs text-gray-400 ml-1">Jam Selesai</label>
                        <input type="time" name="jam_selesai"
                            class="border border-gray-200 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                    </div>

                    <div class="flex items-end">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-4 py-2.5 w-full transition-colors shadow-lg shadow-blue-100">
                            Simpan Shift
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- TABEL SHIFT --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100 text-gray-600">
                    <tr>
                        <th class="p-4 font-semibold">Nama Shift</th>
                        <th class="p-4 font-semibold">Jam Kerja</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse ($shifts as $shift)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4">
                            <span class="font-medium text-gray-700">{{ $shift->nama_shift }}</span>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2 text-gray-600 bg-gray-100 px-3 py-1 rounded-full w-fit text-sm">
                                <i class="bi bi-clock text-xs"></i>
                                {{ $shift->jam_mulai }} — {{ $shift->jam_selesai }}
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex gap-4 justify-center items-center">
                                <a href="{{ route('admin.shift.edit', $shift->id) }}"
                                    class="text-blue-500 hover:text-blue-700 transition-colors flex items-center gap-1 text-sm font-medium">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <form method="POST"
                                    action="{{ route('admin.shift.destroy', $shift->id) }}"
                                    onsubmit="return confirm('Hapus shift ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-400 hover:text-red-600 transition-colors flex items-center gap-1 text-sm font-medium">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                <i class="bi bi-calendar-x text-4xl"></i>
                                <p>Belum ada shift yang terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Tambahkan di layout atau di sini untuk Icon --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection