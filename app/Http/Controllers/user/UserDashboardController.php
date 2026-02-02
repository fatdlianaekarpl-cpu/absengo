<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\IzinCuti;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('shift');
        $today = Carbon::today()->toDateString();

        $isIzinHariIni = IzinCuti::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->exists();

        $shiftHariIni = $user->shift;

        $absensi = Absensi::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->limit(10)
            ->get();

        return view('user.dashboard', [
            'user'            => $user,
            'shiftHariIni'    => $shiftHariIni,
            'absensi'         => $absensi,
            'sisaCuti'        => $user->sisa_cuti,
            'sisaIzin'        => $user->sisa_izin,
            'isIzinHariIni'   => $isIzinHariIni, 
        ]);
    }

    public function absenMasuk()
    {
        $user  = Auth::user();
        $today = Carbon::today()->toDateString();

        $izinHariIni = IzinCuti::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->exists();

        if ($izinHariIni) {
            return back()->with('error', 'Anda sedang izin / cuti hari ini.');
        }

        if (Absensi::where('user_id', $user->id)->whereDate('tanggal', $today)->exists()) {
            return back()->with('error', 'Anda sudah absen masuk hari ini.');
        }

        $shift = $user->shift;
        $now = Carbon::now();
        $terlambatMenit = 0;
        $status = 'Hadir';

        if ($shift) {
            $jamMulai = Carbon::parse($today . ' ' . $shift->jam_mulai);
            if ($now->gt($jamMulai)) {
                $terlambatMenit = $jamMulai->diffInMinutes($now);
                $status = 'Terlambat';
            }
        }

        Absensi::create([
            'user_id'         => $user->id,
            'shift_id'        => $shift ? $shift->id : null,
            'tanggal'         => $today,
            'jam_masuk'       => $now->format('H:i:s'),
            'terlambat_menit' => $terlambatMenit,
            'status'          => $status,
            'keterangan'      => $terlambatMenit > 0
                ? "Terlambat {$terlambatMenit} menit"
                : "Hadir Tepat Waktu",
        ]);

        return back()->with('success', 'Absen masuk berhasil!');
    }

    public function absenPulang()
    {
        $user  = Auth::user();
        $today = Carbon::today()->toDateString();

        $izinHariIni = IzinCuti::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->exists();

        if ($izinHariIni) {
            return back()->with('error', 'Anda sedang izin / cuti hari ini.');
        }

        $absen = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$absen) {
            return back()->with('error', 'Belum absen masuk.');
        }

        if ($absen->jam_keluar) {
            return back()->with('error', 'Anda sudah absen pulang.');
        }

        $shift = $user->shift;
        $now = Carbon::now();
        $lemburMenit = 0;
        $status = $absen->status;

        if ($shift) {
            $jamSelesai = Carbon::parse($today . ' ' . $shift->jam_selesai);
            if ($shift->jam_selesai < $shift->jam_mulai) {
                $jamSelesai->addDay();
            }
            if ($now->gt($jamSelesai)) {
                $lemburMenit = $jamSelesai->diffInMinutes($now);
                $status = 'Lembur';
            }
        }

        $absen->update([
            'jam_keluar'   => $now->format('H:i:s'),
            'lembur_menit' => $lemburMenit,
            'status'       => $status,
            'keterangan'   => $lemburMenit > 0
                ? "Lembur {$lemburMenit} menit"
                : $absen->keterangan,
        ]);

        return back()->with('success', 'Absen pulang berhasil!');
    }
}
