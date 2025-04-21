<?php
session_start();

// Cek apakah user sudah login sebagai siswa
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'siswa') {
    header("Location: ../../login.php");
    exit;
}

$user = $_SESSION['user'];
$role = $user['role']; // role: 'admin', 'walikelas', atau 'siswa'

require_once __DIR__ . '/../../includes/db.php';

// Ambil data siswa yang login
$siswa_id = $_SESSION['user']['id'];
$siswa_query = "
SELECT 
s.id,
s.nama_lengkap,
s.nisn,
k.nama_kelas
FROM tb_siswa s
LEFT JOIN tb_kelas k ON s.kelas_id = k.id_kelas
WHERE s.id = ?";

$stmt = mysqli_prepare($conn, $siswa_query);
mysqli_stmt_bind_param($stmt, "i", $siswa_id);
mysqli_stmt_execute($stmt);
$siswa_result = mysqli_stmt_get_result($stmt);
$siswa_data = mysqli_fetch_assoc($siswa_result);

// Ambil total kasus siswa
$total_query = "SELECT COUNT(*) as total FROM tb_kasus WHERE siswa_id = ?";
$stmt = mysqli_prepare($conn, $total_query);
mysqli_stmt_bind_param($stmt, "i", $siswa_id);
mysqli_stmt_execute($stmt);
$total_result = mysqli_stmt_get_result($stmt);
$total_cases = mysqli_fetch_assoc($total_result)['total'];

// Ambil daftar kasus siswa
$kasus_query = "
SELECT 
k.id_kasus,
k.deskripsi_kasus,
k.tanggal_kasus
FROM tb_kasus k
WHERE k.siswa_id = ?
ORDER BY k.tanggal_kasus DESC";

$stmt = mysqli_prepare($conn, $kasus_query);
mysqli_stmt_bind_param($stmt, "i", $siswa_id);
mysqli_stmt_execute($stmt);
$kasus_result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Kasus - <?= htmlspecialchars($siswa_data['nama_lengkap']) ?></title>

    <link rel="stylesheet" href="/assets/css/styles.css">

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/views/component/sidebar.php'); ?>

        <div class="main-content content-siswa">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">👤</div>
                    <div class="profile-info">
                        <h1><?= htmlspecialchars($siswa_data['nama_lengkap']) ?></h1>
                        <p>NISN: <?= htmlspecialchars($siswa_data['nisn']) ?></p>
                        <p>Kelas: <?= htmlspecialchars($siswa_data['nama_kelas'] ?? "Belum ditentukan") ?></p>
                        <p>Total Kasus: <?= $total_cases ?></p>
                    </div>
                </div>
            </div>
            <div class="cases-card">
                <h2>Riwayat Kasus</h2>
                <?php if (mysqli_num_rows($kasus_result) > 0): ?>
                    <?php while ($kasus = mysqli_fetch_assoc($kasus_result)): ?>
                        <div class="case-item">
                            <strong><?= date('d M Y', strtotime($kasus['tanggal_kasus'])) ?></strong>
                            <p><?= nl2br(htmlspecialchars($kasus['deskripsi_kasus'])) ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <p>Tidak Ada Riwayat Kasus</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>