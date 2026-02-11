@extends('layout.main')

@section('page-title', 'KATEGORI')

@section('content')

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Kategori</h2>

        <a href="/kategori/create" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700">
            + Tambah Kategori
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">NO</th>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4">Jumlah Alat</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($kategori as $k)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $k->nama }}</td>
                        <td class="px-6 py-4 text-center space-x-2">{{ $k->alats_sum_jumlah ?? 0 }}</td>
                        <td class="px-6 py-4 text-center space-x-2">

                            <a href="/kategori/{{ $k->id_kategori }}/edit" class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <form action="/kategori/{{ $k->id_kategori }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline"
                                    onclick="return confirm('Yakin hapus kategori?')">
                                    Hapus
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-gray-400">
                            Belum ada Kategori
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
