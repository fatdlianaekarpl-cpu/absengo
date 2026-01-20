<!DOCTYPE html>
<html>
<head>
    <title>Rekap Izin & Cuti Karyawan</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 1px solid #000; padding-bottom: 10px; }
        .user-section { margin-top: 20px; background-color: #f9f9f9; padding: 10px; border: 1px solid #eee; }
        .user-name { font-size: 13px; font-weight: bold; color: #2d3748; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; margin-bottom: 15px; }
        th { background-color: #4a5568; color: white; padding: 7px; text-transform: uppercase; font-size: 10px; }
        td { padding: 7px; border: 1px solid #e2e8f0; text-align: center; }
        .text-left { text-align: left; }
        .badge { font-weight: bold; font-size: 9px; padding: 2px 5px; border-radius: 3px; }
        .status-disetujui { color: #2f855a; }
        .status-ditolak { color: #c53030; }
        .status-menunggu { color: #b7791f; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin:0;">LAPORAN REKAP IZIN & CUTI</h2>
        <p style="margin:5px 0;">Filter Status: {{ strtoupper($status) }} | Per Tanggal: {{ $tanggal_cetak }}</p>
    </div>

    @forelse($izinGrouped as $namaKaryawan => $daftarIzin)
        <div class="user-name">Karyawan: {{ $namaKaryawan }}</div>
        <table>
            <thead>
                <tr>
                    <th width="15%">Jenis</th>
                    <th width="30%">Periode</th>
                    <th width="35%">Alasan</th>
                    <th width="20%">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($daftarIzin as $item)
                <tr>
                    <td><strong>{{ strtoupper($item->jenis) }}</strong></td>
                    <td>
                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }} - 
                        {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') }}
                    </td>
                    <td class="text-left">{{ $item->alasan }}</td>
                    <td>
                        <span class="badge status-{{ strtolower($item->status) }}">
                            {{ strtoupper($item->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <p style="text-align: center; color: #999; margin-top: 50px;">Tidak ada data ditemukan untuk kriteria ini.</p>
    @endforelse

    <div style="margin-top: 30px; text-align: right; font-style: italic; font-size: 9px;">
        Dokumen ini dibuat otomatis oleh Sistem Absensi pada {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>