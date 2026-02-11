<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogService;

class ActivityLogger
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!Auth::check()) {
            return $response;
        }

        $method = $request->method();

        // HANYA catat aksi yang mengubah data
        if (!in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return $response;
        }

        $path = $request->path();

        $description = $this->resolveDescription($method, $path);

        ActivityLogService::log(
            strtoupper($method) . ' ' . $path,
            $description
        );

        return $response;
    }


    private function resolveDescription(string $method, string $path): string
    {
        return match (true) {

            // ===== AUTH =====
            $method === 'POST' && $path === 'login'
            => 'Login ke sistem',

            $method === 'POST' && $path === 'logout'
            => 'Logout dari sistem',

            // ===== USER =====
            $method === 'POST' && $path === 'user'
            => 'Membuat user',

            $method === 'PUT' && str_starts_with($path, 'user/')
            => 'Mengubah data user',

            $method === 'DELETE' && str_starts_with($path, 'user/')
            => 'Menghapus user',

            // ===== ALAT =====
            $method === 'POST' && $path === 'alat'
            => 'Menambah alat',

            $method === 'PUT' && str_starts_with($path, 'alat/')
            => 'Mengubah alat',

            $method === 'DELETE' && str_starts_with($path, 'alat/')
            => 'Menghapus alat',

            // ===== KATEGORI =====
            $method === 'POST' && $path === 'kategori'
            => 'Menambah kategori',

            $method === 'PUT' && str_starts_with($path, 'kategori/')
            => 'Mengubah kategori',

            $method === 'DELETE' && str_starts_with($path, 'kategori/')
            => 'Menghapus kategori',

            // ===== PEMINJAMAN =====
            $method === 'POST' && $path === 'peminjaman'
            => 'Meminjam alat',

            $method === 'PUT' && str_contains($path, 'ajukan')
            => 'Mengajukan pengembalian',

            $method === 'DELETE' && str_starts_with($path, 'peminjaman/')
            => 'Menghapus peminjaman',

            // ===== PENGEMBALIAN =====
            $method === 'PUT' && str_contains($path, 'setujui')
            => 'Menyetujui pengembalian',

            // ===== DEFAULT =====
            default => 'Mengakses halaman',
        };
    }
}
