<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Barang extends Model
{
    use HasUuids;

    protected $table = 'barang';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nama_barang', 'stock', 'satuan'];

    public function transaksiRequests()
    {
        return $this->hasMany(TransaksiRequest::class, 'barang_id');
    }
}