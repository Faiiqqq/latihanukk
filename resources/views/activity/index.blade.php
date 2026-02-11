@extends('layout.main')

@section('page-title', 'Activity Log')

@section('content')

    <div class="max-w-6xl mx-auto mt-6">

        <div class="bg-gray-50 border border-gray-200 rounded-2xl shadow-sm">

            {{-- HEADER + FILTER --}}
            <div class="px-6 py-4 border-b border-gray-200">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            Activity Log
                        </h2>
                        <p class="text-xs text-gray-500">
                            Riwayat semua aksi POST / PUT / DELETE oleh user
                        </p>
                    </div>

                    <form method="GET" class="flex flex-wrap gap-2">

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari aksi / user..."
                            class="rounded text-sm p-2 border border-gray-300 focus:border-blue-500">

                        <select name="role"
                            class="rounded text-sm p-2 border border-gray-300 focus:border-blue-500">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="peminjam" {{ request('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                        </select>

                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                            Filter
                        </button>

                    </form>

                </div>
            </div>


            {{-- TABLE --}}
            <div class="p-6">

                <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
                    <table class="w-full text-sm">

                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">User</th>
                                <th class="px-4 py-3 text-center">Role</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                                <th class="px-4 py-3 text-left">Deskripsi</th>
                                <th class="px-4 py-3 text-left">Waktu</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @forelse($logs as $index => $log)
                                <tr class="hover:bg-gray-50">

                                    <td class="px-4 py-3">
                                        {{ $logs->firstItem() + $index }}
                                    </td>

                                    <td class="px-4 py-3 font-medium">
                                        {{ $log->user_name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        @switch($log->role)
                                            @case('admin')
                                                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                                    ADMIN
                                                </span>
                                            @break

                                            @case('petugas')
                                                <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                                    PETUGAS
                                                </span>
                                            @break

                                            @default
                                                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                                    PEMINJAM
                                                </span>
                                        @endswitch
                                    </td>

                                    <td class="px-4 py-3 font-semibold text-blue-600">
                                        {{ $log->aksi }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $log->deskripsi ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-xs text-gray-500">
                                        {{ $log->created_at->format('d M Y H:i') }}
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-10 text-gray-400">
                                        Belum ada aktivitas
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>


                {{-- PAGINATION --}}
                @if (method_exists($logs, 'links'))
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        {{ $logs->withQueryString()->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>

@endsection
