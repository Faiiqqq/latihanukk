<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamen';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'id_user',
        'id_alat',
        'jumlah',
        'tgl_pinjam',
        'tgl_kembali',
        'status',
        'denda'
    ];
    protected $casts = [
        'tgl_pinjam' => 'datetime',
        'tgl_kembali' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat', 'id_alat');
    }
    public function hitungDenda()
    {
        if (!$this->tgl_kembali) {
            return 0;
        }

        $batas = $this->tgl_kembali->startOfDay();
        $hariIni = now()->startOfDay();

        if ($hariIni->lte($batas)) {
            return 0;
        }

        $hariTerlambat = $batas->diffInDays($hariIni);

        return $hariTerlambat * 5000;
    }
}
