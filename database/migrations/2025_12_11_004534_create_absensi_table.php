<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Tambahkan shift_id agar kita tahu absen ini merujuk ke shift mana
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->nullOnDelete();
            
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            
            // Menit keterlambatan dan lembur (Penting agar tidak error)
            $table->integer('terlambat_menit')->default(0);
            $table->integer('lembur_menit')->default(0);
            
            // Update enum status agar mencakup 'Lembur'
            $table->enum('status', ['Hadir', 'Terlambat', 'Lembur', 'Izin', 'Cuti'])->default('Hadir');
            
            $table->string('keterangan')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};