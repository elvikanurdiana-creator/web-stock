<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\TransaksiRequest;
use App\Models\Riwayat;

class User extends Authenticatable
{
    use HasUuids;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['username', 'password', 'role'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function transaksiRequests()
    {
        return $this->hasMany(TransaksiRequest::class, 'user_id');
    }

    public function riwayat()
    {
        return $this->hasMany(Riwayat::class, 'actor_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }
}