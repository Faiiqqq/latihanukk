@extends('layout.main')

@section('page-title', 'EDIT KATEGORI')

@section('content')

    <form action="/kategori/{{ $kategori->id_kategori }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nama Kategori
            </label>
            <input type="text" name="nama" value="{{ $kategori->nama }}"
                class="w-full rounded text-sm p-2
                    bg-linear-to-b from-gray-50 to-gray-100
                    border border-gray-300
                    hover:border-gray-400">

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="/kategori"
                    class="px-5 py-2 text-sm font-medium text-gray-700
                    bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Batal
                </a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>

@endsection
