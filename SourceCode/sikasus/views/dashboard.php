<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../includes/db.php';

// Ambil data user dari session
$user = $_SESSION['user'];
$role = $user['role']; // role: 'admin', 'walikelas', atau 'siswa'

if ($role === "siswa") {
    header("Location: siswa/dashboard.php");
}

?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/component/header.php'; ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <div class="row">
            <h1>Selamat Datang, <?= $role; ?>!</h1>
            <br>
            <div>Di dashboard ini, Anda dapat mengelola data kasus yang terkait melalui menu
            yang tersedia di sidebar.</div>
            <p>Pastikan Anda menggunakan fitur-fitur dengan bijak. Jika membutuhkan bantuan, silakan hubungi
                administrator melalui menu <em>Bantuan</em>.</p>
            </div>
        </div>
    </main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/views/component/footer.php'; ?>