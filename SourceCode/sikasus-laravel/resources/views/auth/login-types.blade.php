<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Kasus Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center py-4 vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Silakan Pilih Jenis Login</h2>
                        <div class="d-grid gap-2">
                            <a href="{{ route('auth.login.form', 'siswa') }}" class="btn btn-outline-primary">Siswa</a>
                            <a href="{{ route('auth.login.form', 'walikelas') }}" class="btn btn-outline-primary">Wali Kelas</a>
                            <a href="{{ route('auth.login.form', 'admin') }}" class="btn btn-outline-primary">Admin</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
