<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Proyek;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    // Tampilkan form register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        // Validasi input (Laravel otomatis mengecek email unik)
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed', // 'confirmed' berarti harus cocok dengan password_confirmation
        ]);

        // Simpan user baru (Password otomatis di-hash oleh Model User atau kita hash manual di sini)
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    // Tampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi dasar
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba login menggunakan fasilitas Auth Laravel (Otomatis cek hash password)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Cegah session fixation
            return redirect()->intended(route('dashboard'));
        }

        // Jika gagal, kembalikan ke halaman login dengan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah!',
        ])->onlyInput('email');
    }

    // Tampilkan dashboard
    public function dashboard()
{
    $user = Auth::user();
    $userId = $user->id;

    // KEAMANASAN & FILTER: Semua query wajib menggunakan where('user_id', $userId)
    $totalProyek = Proyek::where('user_id', $userId)->count();
    $statusPerencanaan = Proyek::where('user_id', $userId)->where('status_proyek', 'Perencanaan')->count();
    $statusProsesRevisi = Proyek::where('user_id', $userId)->whereIn('status_proyek', ['Proses', 'Revisi'])->count();
    $statusSelesai = Proyek::where('user_id', $userId)->where('status_proyek', 'Selesai')->count();

    // Ambil 5 data proyek terbaru milik siswa login
    $proyekTerbaru = Proyek::where('user_id', $userId)->latest()->take(5)->get();

    return view('dashboard', compact('user', 'totalProyek', 'statusPerencanaan', 'statusProsesRevisi', 'statusSelesai', 'proyekTerbaru'));
}

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout(); // Hapus session login
        
        $request->session()->invalidate();
        $request->session()->regenerateToken(); // Cegah CSRF
        
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}