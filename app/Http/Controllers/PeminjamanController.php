<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $peminjamen = Peminjaman::with(['user', 'alat'])
            ->where('id_user', Auth::id())
            ->latest()
            ->get();

        return view('peminjaman.main', compact('peminjamen'));
    }

    public function create()
    {
        return view('peminjaman.create', [
            'alats' => Alat::where('jumlah', '>', 0)->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_alat' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tgl_kembali' => 'required|date'
        ]);

        // Cek stok SEBELUM transaction
        $alat = Alat::findOrFail($request->id_alat);

        if ($alat->jumlah < $request->jumlah) {
            return redirect()->back()
                ->with('error', 'Stok tidak cukup! Tersedia: ' . $alat->jumlah . ' unit')
                ->withInput();
        }

        DB::transaction(function () use ($request, $alat) {
            $alat->decrement('jumlah', $request->jumlah);

            Peminjaman::create([
                'id_user' => Auth::id(),
                'id_alat' => $request->id_alat,
                'jumlah' => $request->jumlah,
                'tgl_pinjam' => now(),
                'tgl_kembali' => $request->tgl_kembali,
                'status' => 'dipinjam',
                'denda' => 0
            ]);
        });

        return redirect()->route('peminjaman.index')
            ->with('success', 'Berhasil meminjam alat');
    }

    public function destroy($id)
    {
        Peminjaman::destroy($id);
        return back()->with('success', 'Data peminjaman berhasil dihapus');
    }

    public function ajukan($id)
    {
        $p = Peminjaman::findOrFail($id);

        // Pastikan milik user yang login
        if ($p->id_user !== Auth::id()) {
            abort(403);
        }

        // Hitung denda jika terlambat
        $denda = $p->hitungDenda();

        $p->update([
            'status' => 'menunggu',
            'denda' => $denda
        ]);

        return back()->with('success', 'Pengajuan pengembalian dikirim' .
            ($denda > 0 ? '. Denda: Rp ' . number_format($denda, 0, ',', '.') : ''));
    }
}
