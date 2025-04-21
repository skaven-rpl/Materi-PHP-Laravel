@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Kasus Baru</h1>

        <form action="{{ route('kasus.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="siswa_id">Nama Siswa</label>
                <select name="siswa_id" id="siswa_id" class="form-control" required>
                    <option value="">Pilih Siswa</option>
                    @foreach ($siswa as $siswaItem)
                        <option value="{{ $siswaItem->id }}">{{ $siswaItem->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="deskripsi_kasus">Deskripsi Kasus</label>
                <textarea name="deskripsi_kasus" id="deskripsi_kasus" class="form-control" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="tanggal_kasus">Tanggal Kasus</label>
                <input type="date" name="tanggal_kasus" id="tanggal_kasus" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
@endsection
