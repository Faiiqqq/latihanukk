<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;


class AlatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // hanya admin & petugas boleh mengelola
        $this->middleware('role:admin,petugas')->except(['index', 'show']);
    }


    public function index()
    {
        $alats = Alat::with('kategori')->get();
        return view('alat.main', compact('alats'));
    }

    public function create()
    {
        return view('alat.create', [
            'kategoris' => Kategori::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jumlah' => 'required|integer|min:1',
            'id_kategori' => 'required'
        ]);

        $alat = Alat::where('nama', $request->nama)->first();

        if ($alat) {
            $alat->increment('jumlah', $request->jumlah);
        } else {
            Alat::create($request->all());
        }

        return redirect()->route('alat.index')->with('success', 'Alat disimpan');
    }

    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'nama' => 'required',
            'jumlah' => 'required|integer|min:1',
            'id_kategori' => 'required'
        ]);

        $alat->update($request->all());

        return redirect()->route('alat.index')->with('success', 'Alat diperbarui');
    }


    public function destroy($id)
    {
        Alat::destroy($id);
        return back()->with('success', 'Alat dihapus');
    }

    public function show(Alat $alat)
    {
        return view('alat.show', compact('alat'));
    }

    public function edit(Alat $alat)
    {
        $kategoris = Kategori::all();

        return view('alat.edit', compact('alat', 'kategoris'));
    }
}
