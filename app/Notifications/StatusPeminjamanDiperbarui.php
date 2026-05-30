<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Peminjaman;

class StatusPeminjamanDiperbarui extends Notification
{
    use Queueable;

    protected $peminjaman;

    public function __construct(Peminjaman $peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $statusText = $this->peminjaman->status === 'disetujui' ? 'DISETUJUI' : 'DITOLAK';
        
        return [
            'peminjaman_id' => $this->peminjaman->id,
            'pesan' => 'Pengajuan peminjaman ' . $this->peminjaman->nama_item . ' Anda telah ' . $statusText,
            'url' => route('customer.peminjaman.index', ['jenis' => $this->peminjaman->jenis_fasilitas]),
        ];
    }
}