@extends('layout.main')

@section('page-title', 'ALAT')

@section('content')

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold">Data Alat</h2>
            <p class="text-sm text-gray-500">Daftar inventaris alat berdasarkan stok</p>
        </div>

        @if(in_array(auth()->user()->role, ['admin','petugas']))
        <a href="/alat/create" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition">
            + Tambah Alat
        </a>
        @endif
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">

            {{-- Head --}}
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Nama Alat</th>
                    <th class="px-6 py-4 text-left">Kategori</th>
                    <th class="px-6 py-4 text-center">Jumlah</th>

                    @if(in_array(auth()->user()->role, ['admin','petugas']))
                    <th class="px-6 py-4 text-center">Aksi</th>
                    @endif
                    
                </tr>
            </thead>

            {{-- Body --}}
            <tbody class="divide-y">
                @forelse ($alats as $alat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>

                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $alat->nama }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $alat->kategori->nama ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold">
                                {{ $alat->jumlah }} unit
                            </span>
                        </td>

                        @if(in_array(auth()->user()->role, ['admin','petugas']))
                        <td class="px-6 py-4 text-center space-x-3">
                            <a href="/alat/{{ $alat->id_alat }}/edit" class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <form action="/alat/{{ $alat->id_alat }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Yakin hapus alat ini?')"
                                    class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-gray-400">
                            Belum ada data alat
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
