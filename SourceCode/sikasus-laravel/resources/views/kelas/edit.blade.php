@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Data Kelas</h1>

        <!-- Form Edit Kelas -->
        <form action="{{ route('kelas.update', $kelas->id_kelas) }}" method="POST">
            @csrf
            @method('PUT') <!-- Method PUT digunakan untuk update data -->

            <div class="form-group">
                <label for="nama_kelas">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" value="{{ $kelas->nama_kelas }}" required>
            </div>

            <div class="form-group">
                <label for="walikelas_id">Wali Kelas</label>
                <select name="walikelas_id" id="walikelas_id" class="form-control" required>
                    <option value="">Pilih Wali Kelas</option>
                    @foreach ($walikelas as $walikelasItem)
                        <option value="{{ $walikelasItem->id_walikelas }}"
                            {{ $kelas->walikelas_id == $walikelasItem->id_walikelas ? 'selected' : '' }}>
                            {{ $walikelasItem->nama_walikelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-warning mt-3">Perbarui</button>
        </form>
    </div>
@endsection
