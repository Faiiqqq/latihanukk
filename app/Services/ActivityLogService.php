<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    public static function log(string $aksi, string $deskripsi ): void
    {
        $user = Auth::user();

        ActivityLog::create([
            'user_id'   => $user?->id_user,
            'user_name' => $user?->nama,
            'role'      => $user?->role,
            'aksi'      => $aksi,
            'deskripsi' => $deskripsi,
        ]);
    }
}
