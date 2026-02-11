<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Alat;
use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Kategori;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layout.dashboard', function ($view) {
            $peminjamen = Peminjaman::with(['user', 'alat'])->get();
            $view->with([
                'totalAlat'     => Alat::sum('jumlah'),   // total stok
                'totalJenis'    => Alat::count(),         // jumlah jenis alat
                'totalKategori' => Kategori::count(),
                'totalUser'     => User::count(),
                'peminjamen' => $peminjamen
            ]);
        });
    }
}
