<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
    Schema::create('transaksi_requests', function (Blueprint $table) {
        $table->uuid('id')->primary(); // Tetap UUID untuk ID Transaksi
        
        // 💡 KITA KEMBALIKAN KE UUID: Menghubungkan ke tabel users yang bertipe UUID
        $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');

        $table->string('status')->default('pending'); // pending | diproses | selesai
        $table->string('alasan')->nullable(); 
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_requests');
    }
};