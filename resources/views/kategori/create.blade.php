@extends('layout.main')

@section('page-title', 'MENAMBAHKAN KATEGORI')

@section('content')

    <div class="max-w-3xl mx-auto mt-6">
        {{-- Card --}}
        <div class="bg-gray-50 border border-gray-200 rounded-2xl shadow-sm">
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">
                    Tambah Kategori Baru
                </h2>
            </div>

            {{-- Form --}}
            <form action="/kategori" method="POST" class="px-6 py-6 space-y-6">
                @csrf
                <div class="">
                    {{-- nama --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama
                        </label>
                        <input type="text" name="nama" required placeholder="Nama Kategori"
                            class="w-full rounded text-sm p-2
                                    bg-linear-to-b from-gray-50 to-gray-100
                                    border border-gray-300
                                    hover:border-gray-400">
                    </div>
                </div>
                {{-- Action --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="/kategori"
                        class="px-5 py-2 text-sm font-medium text-gray-700
                        bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium text-white
                        bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
