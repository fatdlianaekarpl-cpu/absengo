@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4 class="fw-bold mb-1">Daftar Karyawan</h4>
                    <p class="text-muted small mb-0">Total: {{ count($users) }} orang</p>
                </div>
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchInput" onkeyup="searchTable()" class="form-control border-start-0 ps-0" placeholder="Cari nama atau email...">
                    </div>
                </div>
                <div class="col-md-3 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-lg"></i> Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="userTable">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Karyawan</th>
                        <th>Dept & Role</th>
                        <th>Shift</th>
                        <th class="text-center">Cuti / Izin</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold">{{ $user->nama }}</div>
                            <div class="text-muted small">{{ $user->email }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $user->department ?? 'N/A' }}</span>
                            <div class="small text-primary mt-1">{{ ucfirst($user->role) }}</div>
                        </td>
                        <td>
                            @if($user->shift)
                                <span class="text-dark">{{ $user->shift->nama_shift }}</span>
                            @else
                                <span class="text-muted small italic">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success-subtle text-success">{{ $user->sisa_cuti }} C</span>
                            <span class="badge bg-warning-subtle text-warning text-dark">{{ $user->sisa_izin }} I</span>
                        </td>
                        <td class="text-center pe-4">
                            <button class="btn btn-outline-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#jatah{{ $user->id }}">
                                Atur
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade" id="jatah{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <form method="POST" action="{{ route('admin.user.updateJatah', $user->id) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header border-0">
                                        <h5 class="fw-bold">Pengaturan Kerja</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-muted small">Mengatur shift dan jatah untuk <strong>{{ $user->nama }}</strong></p>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Pilih Shift</label>
                                            <select name="shift_id" class="form-select">
                                                <option value="">-- Pilih Shift --</option>
                                                @foreach($shifts as $shift)
                                                    <option value="{{ $shift->id }}" {{ $user->shift_id == $shift->id ? 'selected' : '' }}>
                                                        {{ $shift->nama_shift }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label small fw-bold">Sisa Cuti</label>
                                                <input type="number" name="sisa_cuti" class="form-control" value="{{ $user->sisa_cuti }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label small fw-bold">Sisa Izin</label>
                                                <input type="number" name="sisa_izin" class="form-control" value="{{ $user->sisa_izin }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="{{ route('admin.user.store') }}">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="fw-bold">Tambah Karyawan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="mb-2">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-2">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <select name="role" class="form-select" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <input type="text" name="department" class="form-control" placeholder="Dept">
                        </div>
                    </div>
                    <select name="shift_id" class="form-select">
                        <option value="">-- Pilih Shift --</option>
                        @foreach($shifts as $shift)
                            <option value="{{ $shift->id }}">{{ $shift->nama_shift }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100">Simpan Karyawan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function searchTable() {
    let input = document.getElementById("searchInput").value.toUpperCase();
    let rows = document.querySelector("#userTable tbody").rows;
    for (let i = 0; i < rows.length; i++) {
        let text = rows[i].cells[0].textContent.toUpperCase();
        rows[i].style.display = text.includes(input) ? "" : "none";
    }
}
</script>

<style>
    body { background-color: #f8f9fa; }
    .card { border-radius: 12px; }
    .btn { border-radius: 8px; }
    .form-control, .form-select { border-radius: 8px; padding: 10px; }
    .bg-success-subtle { background-color: #e8f5e9; color: #2e7d32; }
    .bg-warning-subtle { background-color: #fff3e0; color: #ef6c00; }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection