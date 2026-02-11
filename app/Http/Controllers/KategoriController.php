<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Alat;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withSum('alats', 'jumlah')->get();

        return view('kategori.main', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        Kategori::create([
            'nama' => $request->nama
        ]);

        return redirect('/kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->only('nama'));

        return redirect('/kategori')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();
        return redirect('/kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
