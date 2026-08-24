<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Storage;

class Barang extends Model
{
    use HasUuids;

    protected $table = 'barang';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // 💡 1. Tambahkan 'foto' ke dalam $fillable
    protected $fillable = ['nama_barang', 'stock', 'satuan', 'foto'];

    public function transaksiRequests()
    {
        return $this->hasMany(TransaksiRequest::class, 'barang_id');
    }

    // 💡 2. Helper otomatis untuk memanggil URL Foto di Blade
    // Cara panggil di Blade nanti tinggal: {{ $barang->foto_url }}
    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return asset('storage/' . $this->foto);
        }

        // Jika barang belum diupload gambarnya, pakai SVG gambar default ini
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama_barang) . '&color=F97316&background=FFEDD5';
    }
}