@extends('layout.main')

@section('page-title', 'TAMBAH ALAT')

@section('content')

    <div class="max-w-3xl mx-auto mt-6">

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">
                    Tambah Alat Baru
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Jika nama alat sudah ada, stok akan otomatis bertambah
                </p>
            </div>

            {{-- Error Validation --}}
            @if ($errors->any())
                <div class="mx-6 mt-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="/alat" method="POST" class="px-6 py-6 space-y-5">
                @csrf

                {{-- Nama Alat --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Alat
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Laptop"
                        class="w-full rounded text-sm p-2
                                    bg-linear-to-b from-gray-50 to-gray-100
                                    border border-gray-300
                                    hover:border-gray-400">
                </div>

                {{-- Jumlah --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Jumlah
                    </label>
                    <input type="number" name="jumlah" value="{{ old('jumlah') }}" min="1" required
                        placeholder="Masukkan jumlah stok"
                        class="w-full rounded text-sm p-2
                                    bg-linear-to-b from-gray-50 to-gray-100
                                    border border-gray-300
                                    hover:border-gray-400">
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kategori
                    </label>
                    <select name="id_kategori" required
                        class="w-full rounded text-sm p-2
                                    bg-linear-to-b from-gray-50 to-gray-100
                                    border border-gray-300
                                    hover:border-gray-400">
                        <option value="">-- Pilih Kategori --</option>

                        @foreach ($kategoris as $k)
                            <option value="{{ $k->id_kategori }}"
                                {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="/alat"
                        class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200">
                        Batal
                    </a>

                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
