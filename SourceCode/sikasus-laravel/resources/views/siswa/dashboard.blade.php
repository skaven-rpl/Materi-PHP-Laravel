@extends('layouts.app')
@section('title', "Riwayat Kasus - $siswa->nama_lengkap ")

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex align-items-center">
                    <div class="fs-2 me-3">👤</div>
                    <div>
                        <h1 class="card-title mb-1">{{ $siswa->nama_lengkap }}</h1>
                        <p class="card-text">NISN: {{ $siswa->nisn }}</p>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Kelas:</strong>
                        {{ $siswa->kelas ? $siswa->kelas->nama_kelas : 'Belum ditentukan' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Total Kasus:</strong>
                        <span class="badge bg-danger">{{ $siswa->kasus->count() }}</span>
                    </div>
                </div>

                <h2 class="h4 mb-3">Riwayat Kasus</h2>

                @if ($siswa->kasus->count() > 0)
                    <div class="list-group">
                        @foreach ($siswa->kasus as $kasusItem)
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">
                                        {{ \Carbon\Carbon::parse($kasusItem->tanggal_kasus)->translatedFormat('d F Y') }}
                                    </h5>
                                </div>
                                <p class="mb-1">{{ $kasusItem->deskripsi_kasus }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info text-center" role="alert">
                        Tidak Ada Riwayat Kasus
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
