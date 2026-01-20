@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Edit Shift</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <form action="{{ route('admin.shift.update', $shift->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="grid grid-cols-3 gap-4">

                <input type="text" name="nama_shift"
                    value="{{ $shift->nama_shift }}"
                    class="border p-2 rounded" required>

                <input type="time" name="jam_mulai"
                    value="{{ $shift->jam_mulai }}"
                    class="border p-2 rounded" required>

                <input type="time" name="jam_selesai"
                    value="{{ $shift->jam_selesai }}"
                    class="border p-2 rounded" required>

            </div>

            <div class="mt-4 flex gap-4">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Update
                </button>
                <a href="{{ route('admin.shift.index') }}"
                    class="text-gray-600">Kembali</a>
            </div>
        </form>
    </div>

</div>
@endsection
