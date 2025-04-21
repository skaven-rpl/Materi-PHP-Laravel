<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelasController extends Controller
{

    public function index()
    {
        $kelas = \App\Models\Kelas::with('walikelas')->get(); // Mengambil semua data kelas beserta wali kelasnya
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $walikelas = \App\Models\Walikelas::all(); // Mengambil semua data wali kelas
        return view('kelas.create', compact('walikelas'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'walikelas_id' => 'required|exists:walikelas,id_walikelas',
        ]);

        \App\Models\Kelas::create($validatedData);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $kelas = \App\Models\Kelas::findOrFail($id); // Mencari kelas berdasarkan ID
        $walikelas = \App\Models\Walikelas::all(); // Mengambil semua wali kelas untuk dropdown
        return view('kelas.edit', compact('kelas', 'walikelas')); // Menampilkan form edit dengan data kelas dan wali kelas
    }

    public function update(Request $request, string $id)
    {
        // Validasi input dari form edit
        $validatedData = $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'walikelas_id' => 'required|exists:walikelas,id_walikelas',
        ]);

        $kelas = \App\Models\Kelas::findOrFail($id); // Menemukan kelas berdasarkan ID
        $kelas->update($validatedData); // Memperbarui data kelas dengan data yang baru

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.'); // Redirect ke daftar kelas dengan pesan sukses
    }

    public function destroy(string $id)
    {
        $kelas = \App\Models\Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
