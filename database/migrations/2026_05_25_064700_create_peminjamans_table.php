<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_item'); // Contoh: "Avanza Veloz" atau "Ruang Rapat Utama"
            $table->enum('jenis_fasilitas', ['mobil', 'ruang']); 
            $table->dateTime('waktu_mulai'); // Menyimpan tanggal sekaligus jam mulai
            $table->dateTime('waktu_selesai'); // Menyimpan tanggal sekaligus jam selesai
            $table->text('keperluan')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
