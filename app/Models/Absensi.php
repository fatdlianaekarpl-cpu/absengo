<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $fillable = [
        'user_id',
        'shift_id', // Tambahkan ini agar tidak error saat create/update
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan',
        'terlambat_menit',
        'lembur_menit',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Shift (Opsional, tapi berguna untuk laporan)
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}