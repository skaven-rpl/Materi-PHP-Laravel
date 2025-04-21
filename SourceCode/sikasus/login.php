<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$type_login = isset($_GET['type']) ? strtolower($_GET['type']) : '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'includes/function.php';

    $type = htmlspecialchars($_POST['type']);
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    try {
        if (login($username, $password, $type)) {
            header("Location: views/dashboard.php");
            exit;
        }
        $username = $type == 'siswa' ? 'NISN' : ($type == 'walikelas' ? 'NIP' : 'Username');
        $error = "$username atau kata sandi salah. Silakan coba lagi.";
    } catch (\Exception $e) {
        $error = $e->getMessage();
    }
}

$titles = [
    'siswa' => ['title' => 'Login Siswa', 'placeholder' => 'Masukkan NISN'],
    'walikelas' => ['title' => 'Login Walikelas', 'placeholder' => 'Masukkan NIP'],
    'admin' => ['title' => 'Login Admin', 'placeholder' => 'Masukkan Nama Pengguna']
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Kasus Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light d-flex align-items-center py-4 vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <?php if (isset($titles[$type_login])): ?>
                            <h2 class="card-title text-center mb-4"><?= $titles[$type_login]['title'] ?></h2>
                            <form method="POST" autocomplete="on">
                                <input type="hidden" name="type" value="<?= $type_login ?>">
                                
                                <div class="mb-3">
                                    <input type="text" name="username" class="form-control" 
                                    placeholder="<?= $titles[$type_login]['placeholder'] ?>" 
                                    autofocus required>
                                </div>
                                
                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control" 
                                    placeholder="Password" required>
                                </div>
                                

                                <?php if ($error): ?>
                                    <div class="alert alert-danger mb-3">
                                        <?= htmlspecialchars($error) ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                    <a href="login.php" class="btn btn-outline-secondary">Kembali</a>
                                </div>
                            </form>
                            
                        <?php else: ?>
                            <h2 class="card-title text-center mb-4">Silakan Pilih Jenis Login</h2>
                            
                            <div class="d-grid gap-2">
                                <a href="?type=siswa" class="btn btn-outline-primary">Siswa</a>
                                <a href="?type=walikelas" class="btn btn-outline-primary">Walikelas</a>
                                <a href="?type=admin" class="btn btn-outline-primary">Admin</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>