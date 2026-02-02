<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IzinCuti;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class IzinCutiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'semua');
        $search = $request->get('search');

        $izin = IzinCuti::with('user')
            ->when($status !== 'semua', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('admin.izin.index', compact('izin'));
    }


    public function approve($id)
    {
        $izin = IzinCuti::with('user')->findOrFail($id);
        $user = $izin->user;

        if (strtolower($izin->status) !== 'menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $jenis = strtolower($izin->jenis);

        if ($jenis === 'cuti') {
            if ($user->sisa_cuti <= 0) {
                return back()->with('error', 'Gagal: Sisa cuti user ini sudah habis.');
            }
            $user->decrement('sisa_cuti', 1);
        } elseif ($jenis === 'izin') {
            if ($user->sisa_izin <= 0) {
                return back()->with('error', 'Gagal: Sisa izin user ini sudah habis.');
            }
            $user->decrement('sisa_izin', 1);
        }

        $tanggalMulai  = Carbon::parse($izin->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($izin->tanggal_selesai);

        for ($tanggal = $tanggalMulai->copy(); $tanggal->lte($tanggalSelesai); $tanggal->addDay()) {
            Absensi::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'tanggal' => $tanggal->toDateString(),
                ],
                [
                    'status'     => ucfirst($jenis),
                    'jam_masuk'  => null,
                    'jam_keluar' => null,
                ]
            );
        }

        $izin->update(['status' => 'disetujui']);

        return back()->with('success', 'Pengajuan berhasil disetujui. Jatah berkurang & riwayat absensi telah diperbarui.');
    }


    public function reject($id)
    {
        $izin = IzinCuti::findOrFail($id);

        if (strtolower($izin->status) !== 'menunggu') {
            return back()->with('error', 'Pengajuan sudah diproses.');
        }

        $izin->update(['status' => 'ditolak']);

        return back()->with('success', 'Pengajuan izin/cuti berhasil ditolak.');
    }


    public function cetakPdf(Request $request)
    {
        $status = $request->get('status', 'semua');
        $search = $request->get('search');

        $dataIzin = IzinCuti::with('user')
            ->when($status !== 'semua', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->get();

        $izinGrouped = $dataIzin->groupBy(function($item) {
            return $item->user->nama ?? 'Tanpa Nama';
        });

        $pdf = Pdf::loadView('admin.izin.cetak-pdf', [
            'izinGrouped' => $izinGrouped,
            'status' => $status,
            'tanggal_cetak' => \Carbon\Carbon::now()->translatedFormat('d F Y')
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Rekap-Izin-Cuti-' . now()->format('YmdHi') . '.pdf');
    }
}