<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('izin_cuti', function (Blueprint $table) {
            $table->id();

            // User yang mengajukan
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Jenis pengajuan
            $table->enum('jenis', ['izin', 'cuti']);

            // Alasan pengajuan
            $table->text('alasan');

            // Periode izin / cuti
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            // Status approval (KONSISTEN)
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])
                ->default('menunggu');

            // Admin yang memproses (optional tapi penting)
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Waktu diputuskan
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            // Index untuk performa
            $table->index('user_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('izin_cuti');
    }
};
