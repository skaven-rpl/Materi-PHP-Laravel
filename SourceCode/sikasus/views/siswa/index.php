<?php
session_start();


require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/function.php';


$user = $_SESSION['user'];
$role = $user['role'];

if ($role === "walikelas") {
    $siswa_query = "SELECT s.id, s.nama_lengkap, s.nisn, s.jenis_kelamin, s.tanggal_lahir, s.alamat, k.nama_kelas, w.nama_walikelas
                FROM tb_siswa s
                LEFT JOIN tb_kelas k ON s.kelas_id = k.id_kelas
                LEFT JOIN tb_walikelas w ON k.walikelas_id = w.id_walikelas
                WHERE w.id_walikelas = {$user['id_walikelas']}
                ORDER BY s.nama_lengkap
                ";
}

// Ambil data siswa
$siswa_data = fetchData($conn, $siswa_query);

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <div class="wrapper">

        <!-- Sidebar -->
        <?php include($_SERVER['DOCUMENT_ROOT'] .'/views/component/sidebar.php'); ?>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Daftar Siswa</h1>
            </header>
            <div class="container">
                <a href="tambah_siswa.php" class="button">Tambah Siswa</a>

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Siswa</th>
                            <th>NISN</th>
                            <th>Kelas</th>
                            <th>Wali Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($siswa_data)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; font-style: italic; height: 25vh">
                                    Tidak ada data yang tersedia.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($siswa_data as $number => $siswa): ?>
                                <tr>
                                    <td><?= $number + 1 ?></td>
                                    <td><?= $siswa['nama_lengkap'] ?></td>
                                    <td><?= $siswa['nisn'] ?></td>
                                    <td><?= $siswa['nama_kelas'] ?></td>
                                    <td><?= $siswa['nama_walikelas'] ?></td>
                                    <td>
                                        <a href="edit_siswa.php?id=<?= $siswa['id'] ?>" class="button">Edit</a>
                                        <a href="hapus_siswa.php?id=<?= $siswa['id'] ?>" class="button"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kasus ini?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</body>

</html>