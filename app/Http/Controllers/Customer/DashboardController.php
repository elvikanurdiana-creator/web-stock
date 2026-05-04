<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\TransaksiRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = session('auth_user.id');
        $stats = [
            'total'     => TransaksiRequest::where('user_id', $userId)->count(),
            'pending'   => TransaksiRequest::where('user_id', $userId)->where('status', 'pending')->count(),
            'disetujui' => TransaksiRequest::where('user_id', $userId)->where('status', 'disetujui')->count(),
            'ditolak'   => TransaksiRequest::where('user_id', $userId)->where('status', 'ditolak')->count(),
        ];

        return view('customer.dashboard', compact('stats'));
    }
}