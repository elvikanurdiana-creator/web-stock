<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TransaksiRequest extends Model
{
    use HasUuids;

    protected $table = 'transaksi_requests';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['user_id', 'barang_id', 'jumlah', 'status', 'alasan'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function riwayat()
    {
        return $this->hasMany(Riwayat::class, 'transaksi_request_id');
    }
}