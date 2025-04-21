<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalikelasController extends Controller
{

    public function index()
    {
        $walikelas = \App\Models\Walikelas::all(); // Mengambil semua data walikelas
        return view('walikelas.index', compact('walikelas')); // Mengirim data ke view
    }

    public function create()
    {
        return view('walikelas.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_walikelas' => 'required|string|max:100',
            'nip' => 'nullable|string|max:20|unique:walikelas,nip',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
        ]);

        \App\Models\Walikelas::create($validatedData);

        return redirect()->route('walikelas.index')->with('success', 'Wali kelas berhasil ditambahkan.');
    }

    public function edit(\App\Models\Walikelas $walikela)
    {
        return view('walikelas.edit', compact('walikela'));
    }

    public function update(Request $request, \App\Models\Walikelas $walikela)
    {
        $validatedData = $request->validate([
            'nama_walikelas' => 'required|string|max:100',
            'nip' => 'nullable|string|max:20|unique:walikelas,nip,' . $walikela->id_walikelas . ',id_walikelas',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
        ]);

        $walikela->update($validatedData);

        return redirect()->route('walikelas.index')->with('success', 'Data wali kelas berhasil diperbarui.');
    }

    public function destroy(\App\Models\Walikelas $walikela)
    {
        $walikela->delete(); // Menghapus data wali kelas
        return redirect()->route('walikelas.index')->with('success', 'Wali kelas berhasil dihapus.'); // Redirect setelah dihapus
    }
}
