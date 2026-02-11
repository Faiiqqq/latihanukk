<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Peminjaman::with(['user', 'alat'])
            ->where('status', 'menunggu')
            ->get();

        return view('pengembalian.index', compact('data'));
    }

    public function setujui($id)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'petugas'])) {
            abort(403);
        }

        DB::transaction(function () use ($id) {
            $p = Peminjaman::with('alat')->findOrFail($id);

            // Kembalikan stok
            $p->alat->increment('jumlah', $p->jumlah);

            // Update status menjadi kembali
            $p->update(['status' => 'kembali']);
        });

        return back()->with('success', 'Pengembalian disetujui');
    }
}