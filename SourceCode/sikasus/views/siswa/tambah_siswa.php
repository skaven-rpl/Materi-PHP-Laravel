<?php
session_start();


require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/function.php';

$user = $_SESSION['user'];
$role = $user['role'];

if ($role === "walikelas") {
    $kelas_query = "SELECT id_kelas FROM tb_kelas WHERE walikelas_id = {$user['id_walikelas']}";
}

$kelas_data = fetchData($conn, $kelas_query); // Gunakan fetch_data untuk hasilkan array data
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <div class="wrapper">

        <!-- Sidebar -->
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/views/component/sidebar.php'); ?>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Tambah Data Siswa</h1>
            </header>
            <div class="container">
                <form action="proses_tambah_siswa.php" method="post">
                    <div>
                        <label for="nama_lengkap">Nama Lengkap:</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" required>
                    </div>

                    <div>
                        <label for="nisn">NISN:</label>
                        <input type="text" id="nisn" name="nisn" required>
                    </div>

                    <div>
                        <label for="jenis_kelamin">Jenis Kelamin:</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label for="tanggal_lahir">Tanggal Lahir:</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>

                    <div>
                        <label for="alamat">Alamat:</label>
                        <textarea id="alamat" name="alamat" required></textarea>
                    </div>

                    <?php if ($role === "walikelas"): ?>
                        <input type="hidden" name="kelas_id" value="<?= $kelas_data[0]['id_kelas'] ?>">
                    <?php endif; ?>

                    <button type="submit">Simpan</button>
                    <a href="index.php" class="button">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>