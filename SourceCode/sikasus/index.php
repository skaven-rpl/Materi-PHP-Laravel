<?php
session_start();

$error = '';
$hasil = null;
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nisn = htmlspecialchars(trim($_POST['nisn'] ?? ''), ENT_QUOTES, 'UTF-8');
    $tanggal_lahir = htmlspecialchars(trim($_POST['tanggal_lahir'] ?? ''), ENT_QUOTES, 'UTF-8');

    if (empty($nisn) || empty($tanggal_lahir)) {
        $error = 'NISN dan Tanggal Lahir harus diisi.';
    } else {
        try {
            require_once 'includes/db.php';

            $stmt = $conn->prepare("
                SELECT 
                    s.nisn, 
                    s.nama_lengkap, 
                    s.tanggal_lahir, 
                    k.deskripsi_kasus,
                    k.tanggal_kasus
                FROM tb_siswa s
                LEFT JOIN tb_kasus k ON s.id = k.siswa_id
                WHERE s.nisn = ? AND s.tanggal_lahir = ?
            ");

            $stmt->bind_param("ss", $nisn, $tanggal_lahir);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $hasil = $result->fetch_all(MYSQLI_ASSOC);
                    $success_message = 'Data ditemukan!';
                } else {
                    $error = 'Data siswa tidak ditemukan.';
                }
            } else {
                throw new Exception('Error executing query');
            }
        } catch (Exception $e) {
            $error .= "Error : $e";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Kasus Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container py-5">

        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="display-6 text-primary">Sistem Informasi Kasus Siswa</h1>
            <p class="text-secondary">Masukkan NISN dan Tanggal Lahir untuk memeriksa data kasus</p>
        </div>

        <!-- Form -->
        <form method="POST" class="p-4 border rounded w-50 mx-auto shadow-sm">
            <div class="mb-3">
                <label for="nisn" class="form-label">NISN</label>
                <input type="text" id="nisn" name="nisn" class="form-control" placeholder="Masukkan NISN"
                    value="<?= htmlspecialchars($_POST['nisn'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control"
                    value="<?= htmlspecialchars($_POST['tanggal_lahir'] ?? '') ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cari Data</button>
        </form>

        <!-- Error Message -->
        <?php if ($error): ?>
            <div class="alert alert-danger mt-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Success Message -->
        <?php if ($success_message): ?>
            <div class="alert alert-success mt-4">
                <?= htmlspecialchars($success_message) ?>
            </div>
        <?php endif; ?>

        <!-- Result Card -->
        <?php if ($hasil): ?>
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    Informasi Kasus Siswa
                </div>
                <div class="card-body">
                    <p><strong>NISN:</strong> <?= htmlspecialchars($hasil[0]['nisn']) ?></p>
                    <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($hasil[0]['nama_lengkap']) ?></p>
                    <p><strong>Tanggal Lahir:</strong> <?= date('d F Y', strtotime($hasil[0]['tanggal_lahir'])) ?></p>

                    <?php if (!empty(array_filter($hasil, fn($item) => $item['deskripsi_kasus']))): ?>
                        <hr>
                        <h5>Daftar Kasus:</h5>
                        <ul class="list-group">
                            <?php foreach ($hasil as $kasus): ?>
                                <?php if ($kasus['deskripsi_kasus']): ?>
                                    <li class="list-group-item">
                                        <strong>Kasus:</strong> <?= htmlspecialchars($kasus['deskripsi_kasus']) ?><br>
                                        <strong>Tanggal Kejadian:</strong> <?= date('d F Y', strtotime($kasus['tanggal_kasus'])) ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Tidak ada kasus tercatat</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Authentication Buttons -->
        <div class="text-center mt-4">
            <?php if (isset($_SESSION['user'])): ?>
                <a href="logout.php" class="btn btn-outline-secondary">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline-primary">Login</a>
            <?php endif; ?>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>