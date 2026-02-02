<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');

            $table->enum('role', ['admin', 'user'])->default('user');

            $table->enum('status', ['Active', 'Inactive'])->default('Active');

            $table->foreignId('shift_id')
                ->nullable()
                ->constrained('shifts')
                ->nullOnDelete();

            $table->integer('sisa_cuti')->default(12);
            $table->integer('sisa_izin')->default(5);

            $table->rememberToken();
            $table->timestamps();

            $table->string('department')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
