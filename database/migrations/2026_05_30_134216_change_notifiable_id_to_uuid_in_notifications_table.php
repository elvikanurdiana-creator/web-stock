<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $blueprint) {
            // Mengubah kolom notifiable_id menjadi string UUID agar muat menampung kode UUID User
            $blueprint->string('notifiable_id', 36)->change();
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $blueprint) {
            // Mengembalikan ke bigint jika di-rollback
            $blueprint->bigInteger('notifiable_id')->change();
        });
    }
};