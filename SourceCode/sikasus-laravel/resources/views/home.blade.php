<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Kasus Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="text-center mb-4">
            <h1 class="display-6 text-primary">Sistem Informasi Kasus Siswa</h1>
            <p class="text-secondary">Masukkan NISN dan Tanggal Lahir untuk memeriksa data kasus</p>
        </div>

        <form action="{{ route('dashboard.search') }}" method="POST" class="p-4 border rounded w-50 mx-auto shadow-sm">
            @csrf
            <div class="mb-3">
                <label for="nisn" class="form-label">NISN</label>
                <input type="text" id="nisn" name="nisn" class="form-control" placeholder="Masukkan NISN"
                    value="{{ old('nisn') }}" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control"
                    value="{{ old('tanggal_lahir') }}" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cari Data</button>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger mt-4">
                {{ $errors->first('message') }}
            </div>
        @endif

        @if (session('success_message'))
            <div class="alert alert-success mt-4">
                {{ session('success_message') }}
            </div>
        @endif

        @if (isset($siswa))
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    Informasi Kasus Siswa
                </div>
                <div class="card-body">
                    <p><strong>NISN:</strong> {{ $siswa->nisn }}</p>
                    <p><strong>Nama Lengkap:</strong> {{ $siswa->nama_lengkap }}</p>
                    <p><strong>Tanggal Lahir:</strong>
                        {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') }}</p>

                    @if ($siswa->kasus->isNotEmpty())
                        <hr>
                        <h5>Daftar Kasus:</h5>
                        <ul class="list-group">
                            @foreach ($siswa->kasus as $kasus)
                                <li class="list-group-item">
                                    <strong>Kasus:</strong> {{ $kasus->deskripsi_kasus }}<br>
                                    <strong>Tanggal Kejadian:</strong>
                                    {{ \Carbon\Carbon::parse($kasus->tanggal_kasus)->format('d F Y') }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tidak ada kasus tercatat</p>
                    @endif
                </div>
            </div>
        @endif

        <div class="text-center mt-4">
            @if (session()->has('user'))
                <a href="{{ route('auth.logout') }}" class="btn btn-outline-secondary">Logout</a>
            @else
                <a href="{{ route('auth.login.types') }}" class="btn btn-outline-primary">Login</a>
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
