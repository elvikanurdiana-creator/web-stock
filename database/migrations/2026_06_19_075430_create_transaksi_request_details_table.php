<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_request_details', function (Blueprint $table) {
            $table->id(); // ID detail boleh integer biasa tidak apa-apa
            
            // 💡 JALUR UTAMA UUID: Menghubungkan ke induk transaksi_requests yang bertipe UUID
            $table->foreignUuid('transaksi_request_id')
                  ->constrained('transaksi_requests')
                  ->cascadeOnDelete();
            
            // Menghubungkan ke tabel barang (Tipe UUID)
            $table->uuid('barang_id');
            $table->foreign('barang_id')
                  ->references('id')
                  ->on('barang')
                  ->cascadeOnDelete();
            
            $table->integer('jumlah_diminta');   
            $table->integer('jumlah_disetujui')->nullable(); 
            
            $table->string('status_item')->default('Pending'); // Pending | Disetujui | Ditolak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_request_details');
    }
};