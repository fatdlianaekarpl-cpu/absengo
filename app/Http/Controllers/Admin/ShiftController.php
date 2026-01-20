<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::orderBy('nama_shift')->get();
        return view('admin.shift.index', compact('shifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_shift' => 'required|string|max:100',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        Shift::create([
            'nama_shift' => $request->nama_shift,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('admin.shift.index')
            ->with('success', 'Shift berhasil ditambahkan');
    }

    public function edit(Shift $shift)
    {
        return view('admin.shift.edit', compact('shift'));
    }

    public function update(Request $request, Shift $shift)
    {
        $request->validate([
            'nama_shift' => 'required|string|max:100',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $shift->update($request->only([
            'nama_shift',
            'jam_mulai',
            'jam_selesai'
        ]));

        return redirect()->route('admin.shift.index')
            ->with('success', 'Shift berhasil diupdate');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();
        return back()->with('success', 'Shift dihapus');
    }
}
