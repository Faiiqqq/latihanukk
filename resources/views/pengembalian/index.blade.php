@extends('layout.main')

@section('page-title', 'PERSETUJUAN PENGEMBALIAN')

@section('content')


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
        <h2 class="text-lg font-semibold">Daftar Pengajuan Pengembalian</h2>
    </div>


    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Peminjam</th>
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

                @forelse ($data as $p)
                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4">{{ $loop->iteration }}</td>

                        <td class="px-6 py-4">{{ $p->user->nama ?? '-' }}</td>

                        <td class="px-6 py-4">{{ $p->alat->nama ?? '-' }}</td>

                        <td class="px-6 py-4 text-center">{{ $p->jumlah }}</td>

                        <td class="px-6 py-4 text-center">{{ $p->tgl_pinjam->format('d M Y H:i') }}</td>

                        <td class="px-6 py-4 text-center">{{ $p->tgl_kembali->format('d M Y') }}</td>

                        {{-- STATUS --}}
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if ($p->denda > 0)
                                <span class="text-red-600 font-semibold">
                                    Rp {{ number_format($p->denda, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-green-600">Tidak ada</span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4 text-center">

                            @auth
                                @if (in_array(auth()->user()->role, ['petugas', 'admin']) && $p->status === 'menunggu')
                                    <form action="{{ route('pengembalian.setujui', $p->id_peminjaman) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button onclick="return confirm('Setujui pengembalian alat ini?')"
                                            class="px-3 py-1 text-xs text-white bg-green-600 rounded-lg hover:bg-green-700">
                                            Setujui
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            @endauth


                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="9" class="text-center py-8 text-gray-400">
                            Belum ada Pengembalian
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

    </div>

@endsection
