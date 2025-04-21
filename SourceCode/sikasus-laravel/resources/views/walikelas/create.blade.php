@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Wali Kelas Baru</h1>

        <form action="{{ route('walikelas.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_walikelas">Nama Wali Kelas</label>
                <input type="text" name="nama_walikelas" id="nama_walikelas" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="nip">NIP</label>
                <input type="text" name="nip" id="nip" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
@endsection
