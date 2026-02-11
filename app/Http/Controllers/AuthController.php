<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Import Auth untuk proses autentikasi (login/logout)
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function showLogin()
    {
        // Mengembalikan view resources/views/login.blade.php
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi input dari form login
        $login = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Coba login menggunakan email & password
        if (Auth::attempt($login)) {

            // Regenerate session ID
            // Penting untuk mencegah Session Fixation Attack (keamanan)
            $request->session()->regenerate();

            // Redirect ke halaman yang sebelumnya ingin diakses
            // jika tidak ada → default ke /peminjaman
            return redirect()->intended('/peminjaman');
        }

        // Jika login gagal → kembali + kirim pesan error
        return redirect()->back()->with('error','Email atau password salah');
    }

    public function logout(Request $request)
    {
        // Hapus data autentikasi user (keluar dari sistem)
        Auth::logout();

        // Hapus semua session
        $request->session()->invalidate();

        // Buat ulang CSRF token baru (keamanan)
        $request->session()->regenerateToken();

        // Redirect ke halaman login
        return redirect('/login');
    }
}
