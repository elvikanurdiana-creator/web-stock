<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('riwayat', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('transaksi_request_id')->constrained('transaksi_requests')->onDelete('cascade');
            $table->foreignUuid('actor_id')->constrained('users')->onDelete('cascade');
            $table->string('status_sebelumnya')->nullable();
            $table->string('status_sesudah')->nullable();
            $table->string('catatan')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat');
    }
};