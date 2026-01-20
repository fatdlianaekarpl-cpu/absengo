<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinCuti extends Model
{
    use HasFactory;

    protected $table = 'izin_cuti';

    protected $fillable = [
        'user_id',
        'jenis',
        'alasan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'approved_by',
        'approved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
