@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Kasus</h1>

        <form action="{{ route('kasus.update', $kasus->id_kasus) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="siswa_id">Nama Siswa</label>
                <select name="siswa_id" id="siswa_id" class="form-control" required>
                    @foreach ($siswa as $siswaItem)
                        <option value="{{ $siswaItem->id }}" {{ $siswaItem->id == $kasus->siswa_id ? 'selected' : '' }}>
                            {{ $siswaItem->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="deskripsi_kasus">Deskripsi Kasus</label>
                <textarea name="deskripsi_kasus" id="deskripsi_kasus" class="form-control" rows="3" required>{{ $kasus->deskripsi_kasus }}</textarea>
            </div>

            <div class="form-group">
                <label for="tanggal_kasus">Tanggal Kasus</label>
                <input type="date" name="tanggal_kasus" id="tanggal_kasus" class="form-control" value="{{ $kasus->tanggal_kasus->format('Y-m-d') }}" required>
            </div>

            <button type="submit" class="btn btn-warning mt-3">Perbarui</button>
        </form>
    </div>
@endsection
