@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Kelas Baru</h1>

        <form action="{{ route('kelas.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_kelas">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="walikelas_id">Wali Kelas</label>
                <select name="walikelas_id" id="walikelas_id" class="form-control" required>
                    <option value="">Pilih Wali Kelas</option>
                    @foreach ($walikelas as $walikelasItem)
                        <option value="{{ $walikelasItem->id_walikelas }}">{{ $walikelasItem->nama_walikelas }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
@endsection
