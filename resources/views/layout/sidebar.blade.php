<aside class="w-64 bg-gray-50 border-r border-gray-200 hidden md:flex flex-col">

    {{-- Logo --}}
    <div class="h-16 flex items-center px-6 border-b border-gray-200">
        <span class="text-sm font-bold">
            APLIKASI PEMINJAMAN ALAT
        </span>
    </div>

    {{-- Menu --}}
    <nav class="flex-1 px-4 py-6 space-y-1 text-sm">

        <a href="/"
            class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
            Dashboard
        </a>

        @if (auth()->user()->role === 'admin')
            <a href="/user"
                class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
                Users
            </a>
            <a href="/pengembalian"
                class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
                Pengembalian
            </a>
            <a href="/alat"
                class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
                Alat
            </a>
            <a href="/activity-log"
                class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
                Log Aktivitas
            </a>
        @endif

        @if (auth()->user()->role === 'petugas')
            <a href="/peminjaman"
                class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
                Peminjaman
            </a>
            <a href="/pengembalian"
                class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
                Pengembalian
            </a>
            <a href="/laporan"
                class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
                laporan
            </a>
        @endif

        @if (auth()->user()->role === 'peminjam')
            <a href="/peminjaman"
                class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
                Peminjaman
            </a>
            <a href="/alat"
                class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
                Alat
            </a>
            <a href="/kategori"
                class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
                Kategori
            </a>
        @endif

    </nav>

    {{-- Logout --}}
    <div class="px-4 py-4 border-t border-gray-200">
        <form action="/logout" method="POST">
            @csrf
            <button class="flex w-full px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg">
                Logout
            </button>
        </form>
    </div>

</aside>
