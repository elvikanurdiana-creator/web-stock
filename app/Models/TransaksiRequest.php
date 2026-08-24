<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids; // 💡 Wajib jika pakai UUID
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransaksiRequest extends Model
{
    use HasUuids; // 💡 Beritahu Laravel kalau id tabel ini pakai UUID

    protected $fillable = ['user_id', 'status', 'alasan'];

    // 💡 RELASI: Satu Transaksi memiliki banyak detail barang (One to Many)
    public function details(): HasMany
    {
        return $this->hasMany(TransaksiRequestDetail::class, 'transaksi_request_id');
    }

    // Relasi ke User (siapa yang mengajukan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}