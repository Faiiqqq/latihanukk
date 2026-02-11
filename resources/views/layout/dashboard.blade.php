@extends('layout.main')

@section('page-title', 'DASHBOARD')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    {{-- Total Stok Alat --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <p class="text-sm text-gray-500">Total Stok Alat</p>
        <h2 class="text-3xl font-bold text-blue-600 mt-2">
            {{ $totalAlat }}
        </h2>
    </div>

    {{-- Jumlah Jenis Alat --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <p class="text-sm text-gray-500">Pending</p>
        <h2 class="text-3xl font-bold text-green-600 mt-2">
            {{ $totalPending }}
        </h2>
    </div>

    {{-- Total Kategori --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <p class="text-sm text-gray-500">Kategori</p>
        <h2 class="text-3xl font-bold text-purple-600 mt-2">
            {{ $totalKategori }}
        </h2>
    </div>

    {{-- Total User --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <p class="text-sm text-gray-500">User</p>
        <h2 class="text-3xl font-bold text-red-600 mt-2">
            {{ $totalUser }}
        </h2>
    </div>

</div>

@endsection
