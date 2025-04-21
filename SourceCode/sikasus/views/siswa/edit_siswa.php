<?php
session_start();

require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/function.php';

$user = $_SESSION['user'];
$role = $user['role'];

// Ambil ID siswa dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data siswa berdasarkan ID
$siswa_query = "SELECT * FROM tb_siswa WHERE id = $id";
$siswa = $conn->query($siswa_query)->fetch_assoc();

if (!$siswa) {
    echo "<script>alert('Data siswa tidak ditemukan.'); window.location.href = 'index.php';</script>";
    exit;
}

if ($role === "walikelas") {
    $kelas_query = "SELECT id_kelas FROM tb_kelas WHERE walikelas_id = {$user['id_walikelas']}";
}

$kelas_data = fetchData($conn, $kelas_query);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <div class="wrapper">

        <!-- Sidebar -->
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/views/component/sidebar.php'); ?>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Edit Data Siswa</h1>
            </header>
            <div class="container">
                <form action="proses_edit_siswa.php" method="post">
                    <input type="hidden" name="id" value="<?= $siswa['id'] ?>">

                    <div>
                        <label for="nama_lengkap">Nama Lengkap:</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= htmlspecialchars($siswa['nama_lengkap']) ?>" required>
                    </div>

                    <div>
                        <label for="nisn">NISN:</label>
                        <input type="text" id="nisn" name="nisn" value="<?= htmlspecialchars($siswa['nisn']) ?>" required>
                    </div>

                    <div>
                        <label for="jenis_kelamin">Jenis Kelamin:</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-laki" <?= $siswa['jenis_kelamin'] === "Laki-laki" ? "selected" : "" ?>>Laki-laki</option>
                            <option value="Perempuan" <?= $siswa['jenis_kelamin'] === "Perempuan" ? "selected" : "" ?>>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label for="tanggal_lahir">Tanggal Lahir:</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?= htmlspecialchars($siswa['tanggal_lahir']) ?>" required>
                    </div>

                    <div>
                        <label for="alamat">Alamat:</label>
                        <textarea id="alamat" name="alamat" required><?= htmlspecialchars($siswa['alamat']) ?></textarea>
                    </div>

                    <?php if ($role === "admin"): ?>
                        <div>
                            <label for="kelas_id">Kelas:</label>
                            <select id="kelas_id" name="kelas_id" required>
                                <?php foreach ($kelas_data as $kelas): ?>
                                    <option value="<?= $kelas['id_kelas'] ?>" <?= $siswa['kelas_id'] == $kelas['id_kelas'] ? "selected" : "" ?>>
                                        <?= htmlspecialchars($kelas['nama_kelas']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="kelas_id" value="<?= $siswa['kelas_id'] ?>">
                    <?php endif; ?>

                    <button type="submit">Simpan</button>
                    <a href="index.php" class="button">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
