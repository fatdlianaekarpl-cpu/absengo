<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // USER
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'nama'     => 'User Absengo',
                'password' => Hash::make('11111'),
                'role'     => 'user',
                'status'   => 'Active',
            ]
        );

        // ADMIN
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'nama'     => 'Admin Absengo',
                'password' => Hash::make('11111'),
                'role'     => 'admin',
                'status'   => 'Active',
            ]
        );
    }
}
