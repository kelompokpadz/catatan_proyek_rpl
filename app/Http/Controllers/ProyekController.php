<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ProyekController extends Controller
{
    // 1. Tampilkan daftar proyek (Sudah dibuat di Tahap 3)
    public function index()
    {
        $proyeks = Proyek::where('user_id', Auth::id())->latest()->paginate(10);
        return view('proyek.index', compact('proyeks'));
    }

    // 2. Tampilkan form tambah proyek
    public function create()
    {
        return view('proyek.create');
    }

    // 3. Proses simpan proyek baru
    public function store(Request $request)
    {
        // Validasi input sesuai kisi-kisi
        $request->validate([
            'nama_proyek' => 'required|string|max:100',
            'jenis_proyek' => 'required|string|max:100',
            'teknologi' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'status_proyek' => 'required|in:Perencanaan,Proses,Revisi,Selesai',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        // Simpan ke database dengan user_id dari session login (KEAMANAN)
        Proyek::create([
            'user_id' => Auth::id(), // PENTING: Mengambil ID user yang sedang login
            'nama_proyek' => $request->nama_proyek,
            'jenis_proyek' => $request->jenis_proyek,
            'teknologi' => $request->teknologi,
            'deskripsi' => $request->deskripsi,
            'status_proyek' => $request->status_proyek,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil ditambahkan!');
    }

    // 4. Tampilkan form edit proyek (DENGAN PENGAMANAN)
    public function edit($id)
    {
        // Cari data berdasarkan ID DAN user_id yang sedang login (Langkah 10)
        $proyek = Proyek::where('id', $id)->where('user_id', Auth::id())->first();

        // Jika data tidak ditemukan, tolak akses
        if (!$proyek) {
            return redirect()->route('proyek.index')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki akses!');
        }

        return view('proyek.edit', compact('proyek'));
    }

    // 5. Proses update proyek (DENGAN PENGAMANAN)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:100',
            'jenis_proyek' => 'required|string|max:100',
            'teknologi' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'status_proyek' => 'required|in:Perencanaan,Proses,Revisi,Selesai',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        // Cari data yang AMAN untuk diupdate
        $proyek = Proyek::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$proyek) {
            return redirect()->route('proyek.index')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki akses!');
        }

        // Update data
        $proyek->update([
            'nama_proyek' => $request->nama_proyek,
            'jenis_proyek' => $request->jenis_proyek,
            'teknologi' => $request->teknologi,
            'deskripsi' => $request->deskripsi,
            'status_proyek' => $request->status_proyek,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil diperbarui!');
    }

    // 6. Proses hapus proyek (DENGAN PENGAMANAN)
    public function destroy($id)
    {
        // Cari data yang AMAN untuk dihapus
        $proyek = Proyek::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$proyek) {
            return redirect()->route('proyek.index')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki akses!');
        }

        $proyek->delete();

        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil dihapus!');
    }

    // 7. Menampilkan halaman laporan untuk dicetak
public function laporan()
{
    // Ambil SEMUA data proyek milik user yang sedang login (tanpa pagination)
    $proyeks = Proyek::where('user_id', Auth::id())->latest()->get();
    $user = Auth::user();
    
    return view('laporan', compact('proyeks', 'user'));
}

public function cetakPDF()
{
    $proyeks = Proyek::where('user_id', Auth::id())->latest()->get();
    $user = Auth::user();
    
    $pdf = Pdf::loadView('laporan.pdf', compact('proyeks', 'user'));
    
    // Set kertas A4 Portrait
    $pdf->setPaper('A4', 'portrait');
    
    // Download atau stream
    return $pdf->stream('Laporan-Proyek-' . $user->name . '.pdf');
}
}