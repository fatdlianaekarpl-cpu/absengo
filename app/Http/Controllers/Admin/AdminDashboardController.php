<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalKaryawan = User::count();

        $karyawanAktif = User::where('status', 'Active')->count();

        $karyawanTidakAktif = User::where('status', 'Inactive')->count();

        $karyawanIzin = User::whereIn('status', ['Izin', 'Cuti'])->count();

        return view('admin.dashboard.index', [
            'totalKaryawan'        => $totalKaryawan,
            'karyawanAktif'        => $karyawanAktif,
            'karyawanTidakAktif'   => $karyawanTidakAktif,
            'karyawanIzin'         => $karyawanIzin,
        ]);
    }
}
