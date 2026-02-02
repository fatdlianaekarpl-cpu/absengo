<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 

class RiwayatAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        $riwayat = Absensi::with('user')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.absensi.index', compact('riwayat', 'bulan', 'tahun'));
    }

    public function cetakPdf(Request $request)
    {
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        $riwayat = Absensi::with('user')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');


        $pdf = Pdf::loadView('admin.absensi.cetak-pdf', [
            'riwayat' => $riwayat,
            'bulan' => $namaBulan,
            'tahun' => $tahun
        ]);

        return $pdf->stream("Laporan-Absensi-$namaBulan-$tahun.pdf");
    }
}