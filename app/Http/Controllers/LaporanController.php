<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\ActivityLogService;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,petugas']);
    }

    // FILTER
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat'])
            ->where('status', 'kembali'); // ← FILTER DISINI

        if ($request->start && $request->end) {
            $query->whereBetween('tgl_pinjam', [$request->start, $request->end]);
        }

        $data = $query->orderBy('tgl_pinjam')->get();

        return view('laporan.index', compact('data'));
    }

    // PDF
    public function pdf(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end'   => 'required|date',
        ]);

        $data = Peminjaman::with(['user', 'alat'])
            ->where('status', 'kembali') // ← FILTER
            ->whereBetween('tgl_pinjam', [$request->start, $request->end])
            ->orderBy('tgl_pinjam')
            ->get();


        // log aktivitas
        ActivityLogService::log(
            'CETAK LAPORAN PDF',
            'Tanggal ' . $request->start . ' s/d ' . $request->end
        );

        $pdf = Pdf::loadView('laporan.pdf', [
            'data' => $data,
            'start' => $request->start,
            'end' => $request->end
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-peminjaman.pdf');
    }
}
