<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Alat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Constructor
    // Semua method di controller ini WAJIB login (middleware auth)
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Ambil data peminjaman:
        // - relasi user & alat (eager loading biar tidak N+1 query)
        // - hanya milik user yang sedang login
        // - urut terbaru
        $query = Peminjaman::with(['user', 'alat'])
            ->latest();

        // Jika bukan admin/petugas → hanya lihat miliknya sendiri
        if (!in_array(Auth::user()->role, ['admin', 'petugas'])) {
            $query->where('id_user', Auth::id());
        }

        $peminjamen = $query->get();

        // Kirim ke view
        return view('peminjaman.main', compact('peminjamen'));
    }

    public function create()
    {
        return view('peminjaman.create', [

            // Hanya tampilkan alat yang stoknya > 0
            'alats' => Alat::where('jumlah', '>', 0)->get()
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'id_alat' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tgl_kembali' => 'required|date'
        ]);

        // Ambil data alat berdasarkan id
        $alat = Alat::findOrFail($request->id_alat);

        // Cek stok sebelum lanjut
        // Jika stok kurang → batalkan
        if ($alat->jumlah < $request->jumlah) {
            return redirect()->back()
                ->with('error', 'Stok tidak cukup! Tersedia: ' . $alat->jumlah . ' unit')
                ->withInput();
        }

        // Gunakan transaction supaya:
        // - stok berkurang
        // - data peminjaman dibuat
        DB::transaction(function () use ($request, $alat) {

            // Kurangi stok alat
            $alat->decrement('jumlah', $request->jumlah);

            // Simpan data peminjaman
            Peminjaman::create([
                'id_user' => Auth::id(),     // user yang login
                'id_alat' => $request->id_alat,
                'jumlah' => $request->jumlah,
                'tgl_pinjam' => now(),
                'tgl_kembali' => $request->tgl_kembali,
                'status' => 'dipinjam',      // status awal
                'denda' => 0                // belum ada denda
            ]);
        });

        return redirect()->route('peminjaman.index')
            ->with('success', 'Berhasil meminjam alat');
    }

    public function destroy($id)
    {
        // Hapus berdasarkan id
        Peminjaman::destroy($id);

        return back()->with('success', 'Data peminjaman berhasil dihapus');
    }

    public function ajukan($id)
    {
        // Cari data peminjaman
        $p = Peminjaman::findOrFail($id);

        // Keamanan:
        // pastikan hanya pemilik data yang bisa mengajukan
        if ($p->id_user !== Auth::id()) {
            abort(403); // forbidden
        }

        // Hitung denda (method dari model Peminjaman)
        // dihitung dari selisih tanggal
        $denda = $p->hitungDenda();

        // Update status & denda
        $p->update([
            'status' => 'menunggu', // menunggu konfirmasi admin/petugas
            'denda' => $denda
        ]);

        return back()->with(
            'success',
            'Pengajuan pengembalian dikirim' .
                ($denda > 0 ? '. Denda: Rp ' . number_format($denda, 0, ',', '.') : '')
        );
    }
}
