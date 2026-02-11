@extends('layout.main')

@section('page-title', 'BUAT PEMINJAMAN')

@section('content')

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="max-w-3xl mx-auto mt-6">

        <div class="bg-gray-50 border border-gray-200 rounded-2xl shadow-sm">

            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">
                    Form Peminjaman Alat
                </h2>
            </div>

            <form action="{{ route('peminjaman.store') }}" method="POST" class="px-6 py-6 space-y-6">
                @csrf

                {{-- Alat --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alat</label>
                    <select name="id_alat" required
                        class="w-full rounded text-sm p-2 border border-gray-300 focus:border-blue-500">
                        <option value="">-- Pilih Alat --</option>
                        @foreach ($alats as $a)
                            <option value="{{ $a->id_alat }}" {{ $a->jumlah == 0 ? 'disabled' : '' }}>
                                {{ $a->nama }}
                                @if ($a->jumlah > 0)
                                    (stok: {{ $a->jumlah }})
                                @else
                                    (stok habis)
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">
                        Alat dengan stok habis otomatis tidak dapat dipilih
                    </p>
                    @error('id_alat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jumlah --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pinjam</label>
                    <input type="number" name="jumlah" min="1" value="{{ old('jumlah') }}" required
                        class="w-full rounded text-sm p-2 border border-gray-300 focus:border-blue-500">
                    @error('jumlah')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Pinjam (Read-only, otomatis hari ini) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
                    <input type="text" value="{{ date('d-m-Y') }}" readonly
                        class="w-full rounded text-sm p-2 border border-gray-300 bg-gray-100 cursor-not-allowed">
                    <p class="text-xs text-gray-400 mt-1">
                        Tanggal pinjam otomatis hari ini
                    </p>
                </div>

                {{-- Tanggal Kembali --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
                    <input type="date" name="tgl_kembali" 
                        value="{{ old('tgl_kembali', date('Y-m-d', strtotime('+1 day'))) }}" 
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                        required
                        class="w-full rounded text-sm p-2 border border-gray-300 focus:border-blue-500">
                    <p class="text-xs text-gray-400 mt-1">
                        Minimal H+1 (besok). Keterlambatan dikenai denda Rp 5.000/hari
                    </p>
                    @error('tgl_kembali')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('peminjaman.index') }}"
                        class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection