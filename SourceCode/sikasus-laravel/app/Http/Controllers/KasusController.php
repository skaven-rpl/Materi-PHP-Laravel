<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kasus = \App\Models\Kasus::with('siswa')->orderBy('tanggal_kasus', 'desc')->get();
        return view('kasus.index', compact('kasus'));
    }

    public function create()
    {
        $siswa = \App\Models\Siswa::all();
        return view('kasus.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'deskripsi_kasus' => 'required',
            'tanggal_kasus' => 'required|date',
            'siswa_id' => 'required|exists:siswa,id',
        ]);

        \App\Models\Kasus::create($validated);
        return redirect()->route('kasus.index')->with('success', 'Data kasus berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $kasus = \App\Models\Kasus::findOrFail($id);
        $siswa = \App\Models\Siswa::orderBy('nama_lengkap')->all();
        return view('kasus.edit', compact('kasus', 'siswa'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'deskripsi_kasus' => 'required',
            'tanggal_kasus' => 'required|date',
            'siswa_id' => 'required|exists:siswa,id'
        ]);

        $kasus = \App\Models\Kasus::findOrFail($id);
        $kasus->update($validated);
        return redirect()->route('kasus.index')->with('success', 'Data kasus berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kasus = \App\Models\Kasus::findOrFail($id);
        $kasus->delete();
        return redirect()->route('kasus.index')->with('success', 'Data kasus berhasil dihapus.');
    }
}
