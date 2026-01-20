<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'department',
        'status',
        'shift_id',
        'sisa_cuti',
        'sisa_izin',
    ];

    protected $hidden = [
        'password',
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
