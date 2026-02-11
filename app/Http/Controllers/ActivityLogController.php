<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    // Method untuk menampilkan daftar log aktivitas
    public function index()
    {
        // Ambil data log dengan urutan terbaru
        $logs = ActivityLog::latest()

            // Filter pencarian (jika ada parameter ?search= di URL)
            // when() hanya dijalankan kalau request('search') tidak kosong
            ->when(request('search'), function ($q) {

                // Cari berdasarkan kolom aksi ATAU user_name
                // LIKE digunakan supaya bisa pencarian sebagian kata
                $q->where('aksi', 'like', '%' . request('search') . '%')
                    ->orWhere('user_name', 'like', '%' . request('search') . '%');
            })

            // Filter berdasarkan role (jika ada parameter ?role=)
            ->when(request('role'), function ($q) {

                // Ambil data sesuai role tertentu saja (misal: admin/petugas/user)
                $q->where('role', request('role'));
            })

            // Batasi hasil 15 data per halaman (pagination)
            ->paginate(15);

        // Kirim data $logs ke view activity.index
        // compact('logs') sama dengan ['logs' => $logs]
        return view('activity.index', compact('logs'));
    }
}
