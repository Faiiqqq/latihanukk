@extends('layout.main')

@section('page-title', 'LAPORAN')

@section('content')

    {{-- Alert --}}
    @if (session('success'))
        <div class="max-w-6xl mx-auto mt-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="max-w-6xl mx-auto mt-6 space-y-6">

        {{-- CARD --}}
        <div class="bg-gray-50 border border-gray-200 rounded-2xl shadow-sm">

            {{-- HEADER --}}
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">
                    Laporan Peminjaman & Pengembalian
                </h2>
            </div>

            <div class="px-6 py-6 space-y-6">

                {{-- FILTER --}}
                <form method="GET" action="{{ route('laporan.index') }}" class="grid md:grid-cols-4 gap-4 items-end">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Dari Tanggal
                        </label>
                        <input type="date" name="start" value="{{ request('start') }}"
                            class="w-full rounded text-sm p-2 border border-gray-300 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Sampai Tanggal
                        </label>
                        <input type="date" name="end" value="{{ request('end') }}"
                            class="w-full rounded text-sm p-2 border border-gray-300 focus:border-blue-500">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                            Tampilkan
                        </button>

                        @if (isset($data) && $data->count())
                            <a href="{{ route('laporan.pdf', request()->query()) }}"
                                class="inline-flex items-center justify-center px-5 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                                PDF
                            </a>
                        @endif
                    </div>

                </form>


                {{-- TABLE --}}
                <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
                    <table class="w-full text-sm">

                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Tanggal</th>
                                <th class="px-4 py-3 text-left">User</th>
                                <th class="px-4 py-3 text-left">Alat</th>
                                <th class="px-4 py-3 text-center">Jumlah</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Denda</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @forelse($data ?? [] as $row)
                                <tr class="hover:bg-gray-50">

                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>

                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($row->tgl_pinjam)->format('d M Y') }}
                                    </td>

                                    <td class="px-4 py-3">{{ $row->user->nama ?? '-' }}</td>

                                    <td class="px-4 py-3">{{ $row->alat->nama ?? '-' }}</td>

                                    <td class="px-4 py-3 text-center">{{ $row->jumlah }}</td>

                                    <td class="px-4 py-3 text-center">
                                        @if ($row->status == 'dipinjam')
                                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                                Dipinjam
                                            </span>
                                        @elseif($row->status == 'menunggu')
                                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                                Menunggu
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                                Kembali
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        @if ($row->denda > 0)
                                            <span class="text-red-600 font-medium">
                                                Rp {{ number_format($row->denda, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-10 text-gray-400">
                                        Pilih tanggal lalu klik "Tampilkan"
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection
