<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #B7CCD4; color: #000; padding: 10px; border: 1px solid #999; }
        td { padding: 8px; border: 1px solid #ccc; text-align: center; }
        .text-left { text-align: left; }
        .status-hadir { color: green; font-weight: bold; }
        .status-telat { color: red; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; font-style: italic; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Laporan Riwayat Absensi Karyawan</div>
        <div>Periode: {{ $bulan }} {{ $tahun }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Karyawan</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayat as $item)
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td class="text-left">{{ $item->user->nama ?? '-' }}</td>
                <td>{{ $item->jam_masuk ?? '--:--' }}</td>
                <td>{{ $item->jam_keluar ?? '--:--' }}</td>
                <td>{{ strtoupper($item->status) }}</td>
                <td class="text-left">
                    @if($item->terlambat_menit > 0) Telat: {{ $item->terlambat_menit }}m @endif
                    @if($item->lembur_menit > 0) Lembur: {{ $item->lembur_menit }}m @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>