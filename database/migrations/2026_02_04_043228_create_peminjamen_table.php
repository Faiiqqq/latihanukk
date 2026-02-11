<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->foreignId('id_alat')->constrained('alats', 'id_alat')->cascadeOnDelete();
            $table->integer('jumlah');
            $table->dateTime('tgl_pinjam');
            $table->dateTime('tgl_kembali');
            $table->enum('status', [
                'dipinjam',
                'menunggu',
                'kembali'
            ])->default('dipinjam');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
