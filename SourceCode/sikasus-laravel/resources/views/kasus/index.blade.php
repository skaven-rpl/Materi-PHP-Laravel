@extends('layouts.app')

@section('title', 'Daftar Kasus')

@section('content')
    <h1>Daftar Kasus</h1>
    <a href="{{ route('kasus.create') }}" class="my-2 btn btn-primary">Tambah Kasus</a>

    <div class="card mb-4">
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Siswa</th>
                        <th>Kasus</th>
                        <th>Tanggal Kasus</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Siswa</th>
                        <th>Kasus</th>
                        <th>Tanggal Kasus</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($kasus as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->siswa->nama_lengkap ?? '' }}</td>
                            <td>{{ $item->deskripsi_kasus }}</td>
                            <td>{{ $item->tanggal_kasus->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('kasus.edit', $item->id_kasus) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('kasus.destroy', $item->id_kasus) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
