<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiRequestDetail extends Model
{
    // Daftarkan kolom yang boleh diisi
    protected $fillable = [
        'transaksi_request_id',
        'barang_id',
        'jumlah_diminta',
        'jumlah_disetujui',
        'status_item'
    ];

    // 💡 RELASI: Detail ini milik sebuah Transaksi Induk (Belongs To)
    public function transaksiRequest(): BelongsTo
    {
        return $this->belongsTo(TransaksiRequest::class, 'transaksi_request_id');
    }

    // 💡 RELASI: Detail ini merujuk ke data Barang
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}