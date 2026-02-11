@extends('layout.main')

@section('page-title', 'PEMINJAMAN')

@section('content')
@auth
    {{-- Alert --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">Data Peminjaman</h2>
        
            @if (auth()->user()->role === 'peminjam')
                <a href="{{ route('peminjaman.create') }}"
                    class="px-4 py-2 text-sm text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition">
                    + Pinjam Alat
                </a>
            @endif
        

    </div>



    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    @if (in_array(auth()->user()->role,['admin','petugas']))
                    <th class="px-6 py-4 text-left">Peminjam</th>
                    @endif
                    <th class="px-6 py-4 text-left">Alat</th>
                    <th class="px-6 py-4 text-center">Jumlah</th>
                    <th class="px-6 py-4 text-center">Tgl Pinjam</th>
                    <th class="px-6 py-4 text-center">Tgl Kembali</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Denda</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse ($peminjamen as $p)
                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4">{{ $loop->iteration }}</td>

                        @if (in_array(auth()->user()->role,['admin','petugas']))
                        <td class="px-6 py-4">
                            {{ $p->user->nama ?? '-' }}
                        </td>
                        @endif

                        <td class="px-6 py-4">
                            {{ $p->alat->nama ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $p->jumlah }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $p->tgl_pinjam->format('d M Y H:i') }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $p->tgl_kembali->format('d M Y') }}
                        </td>


                        {{-- STATUS --}}
                        <td class="px-6 py-4 text-center">
                            @switch($p->status)
                                @case('dipinjam')
                                    <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                        Dipinjam
                                    </span>
                                @break

                                @case('menunggu')
                                    <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                        Menunggu
                                    </span>
                                @break

                                @default
                                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                        Kembali
                                    </span>
                            @endswitch
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if ($p->denda > 0)
                                <span class="text-red-600 font-semibold">
                                    Rp {{ number_format($p->denda, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4 text-center space-x-2">

                            {{-- Ajukan pengembalian --}}

                                @if (auth()->user()->role === 'peminjam' && $p->status === 'dipinjam' && $p->id_user === auth()->id())
                                    <form action="{{ route('peminjaman.ajukan', $p->id_peminjaman) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button class="text-yellow-600 hover:underline">
                                            Ajukan Pengembalian
                                        </button>
                                    </form>
                                @endif


                            {{-- Hapus --}}

                                @if (auth()->user()->role === 'admin')
                                    <form action="{{ route('peminjaman.destroy', $p->id_peminjaman) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Hapus data ini?')"
                                            class="text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                @endif


                        </td>

                    </tr>

                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-8 text-gray-400">
                                Belum ada data peminjaman
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
        @endauth
    @endsection
