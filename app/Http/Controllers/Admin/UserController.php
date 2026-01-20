<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('shift')->where('role', 'user')->get();
        $shifts = Shift::orderBy('nama_shift')->get();

        return view('admin.user.index', compact('users', 'shifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:5',
            'department' => 'nullable|string',
            'shift_id'   => 'nullable|exists:shifts,id',
        ]);

        User::create([
            'nama'       => $request->nama,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'user',
            'department' => $request->department,
            'shift_id'   => $request->shift_id,
            'status'     => 'Active',
            'sisa_cuti'  => 12,
            'sisa_izin'  => 5,
        ]);

        return back()->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function updateJatah(Request $request, $id)
        {
            $request->validate([
                'shift_id'  => 'nullable|exists:shifts,id',
                'sisa_cuti' => 'required|integer|min:0',
                'sisa_izin' => 'required|integer|min:0',
            ]);

            $user = User::findOrFail($id);

            $user->update([
                'shift_id'  => $request->shift_id,
                'sisa_cuti' => $request->sisa_cuti,
                'sisa_izin' => $request->sisa_izin,
            ]);

            return back()->with('success', 'Jatah & shift berhasil diperbarui');
        }


    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Karyawan dihapus');
    }
}
