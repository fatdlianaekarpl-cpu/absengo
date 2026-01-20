<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\IzinCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinCutiController extends Controller
{

    public function index()
{
    // Perbaikan: gunakan user_id, bukan id
    $izinCuti = IzinCuti::where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('user.izin-cuti.index', compact('izinCuti'));
}

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'jenis' => 'required|in:Izin,Cuti',
            'alasan' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // VALIDASI JATAH SEBELUM SUBMIT
        if ($request->jenis === 'Cuti' && $user->sisa_cuti <= 0) {
            return back()->with('error', 'Maaf, sisa cuti Anda sudah habis.');
        }

        if ($request->jenis === 'Izin' && $user->sisa_izin <= 0) {
            return back()->with('error', 'Maaf, sisa izin Anda sudah habis.');
        }

        IzinCuti::create([
            'user_id' => $user->id,
            'jenis' => $request->jenis,
            'alasan' => $request->alasan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'menunggu', 
        ]);

        return redirect()->back()->with('success', 'Pengajuan berhasil dikirim, menunggu persetujuan admin.');
    }
}
