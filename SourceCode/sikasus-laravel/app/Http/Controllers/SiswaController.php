<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{

    public function index()
    {
        $siswa = \App\Models\Siswa::with('kelas')->orderBy('nama_lengkap')->get(); // Mengambil semua siswa beserta informasi kelasnya
        return view('siswa.index', compact('siswa')); // Mengirim data siswa ke view
    }

    public function create()
    {
        $kelas = \App\Models\Kelas::all(); // Mengambil semua data kelas untuk dropdown
        return view('siswa.create', compact('kelas')); // Mengirim data kelas ke form create
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nisn' => 'required|unique:siswa,nisn|max:20',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id_kelas', // Pastikan kelas_id ada di tabel kelas
        ]);

        \App\Models\Siswa::create($request->all()); // Menyimpan data siswa baru
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $siswa = \App\Models\Siswa::findOrFail($id); // Menemukan siswa berdasarkan ID
        $siswa->delete(); // Menghapus data siswa
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus!');
    }

    public function dashboard()
    {
        $siswa = \App\Models\Siswa::with(['kasus', 'kelas'])->findOrFail(session('user')['id']); // Menampilkan data siswa dengan relasi kelas
        return view('siswa.dashboard', compact('siswa')); // Mengirim data siswa ke view
    }

}
