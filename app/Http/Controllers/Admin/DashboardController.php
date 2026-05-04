<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\TransaksiRequest;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_barang'     => Barang::count(),
            'total_users'      => User::where('role', 'customer')->count(),
            'pending'          => TransaksiRequest::where('status', 'pending')->count(),
            'disetujui'        => TransaksiRequest::where('status', 'disetujui')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}