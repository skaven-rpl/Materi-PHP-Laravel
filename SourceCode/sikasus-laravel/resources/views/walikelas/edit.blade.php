@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Data Wali Kelas</h1>

        <form action="{{ route('walikelas.update', $walikela->id_walikelas) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_walikelas">Nama Wali Kelas</label>
                <input type="text" name="nama_walikelas" id="nama_walikelas" class="form-control" value="{{ $walikela->nama_walikelas }}" required>
            </div>
            <div class="form-group">
                <label for="nip">NIP</label>
                <input type="text" name="nip" id="nip" class="form-control" value="{{ $walikela->nip }}" required>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>

	        <div class="form-group">
	            <label for="alamat">Alamat</label>
	            <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ $walikela->alamat }}</textarea>
	        </div>

        <button type="submit" class="btn btn-warning mt-3">Perbarui</button>
    </form>
</div>

@endsection
