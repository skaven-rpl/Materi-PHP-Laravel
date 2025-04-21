<?php
require_once 'db.php';

function fetchData($conn, $query) {
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Kesalahan pada kueri: " . mysqli_error($conn));
    }
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

































function login($username, $password, $type): bool
{
    global $conn;

    if ($type === "admin") {
        $stmt = $conn->prepare("SELECT * FROM tb_user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $_SESSION['user']['role'] = 'admin';
            return true;
        }
    }

    if ($type === "siswa") {
        $stmt = $conn->prepare("SELECT * FROM tb_siswa WHERE nisn = ? AND nisn = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user'] = $user;
            $_SESSION['user']['role'] = 'siswa';
            return true;
        }
    }

    if ($type === "walikelas") {
        $stmt = $conn->prepare("SELECT * FROM tb_walikelas WHERE nip = ? AND nip = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user'] = $user;
            $_SESSION['user']['role'] = 'walikelas';
            return true;
        }
    }

    return false;
}

function cekAkses($role_izin)
{
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role_izin) {
        header('Location: /login.php');
        exit();
    }
}

function jsAlert($message, $redirectUrl = null) {
    echo "<script>";
    echo "alert('" . addslashes($message) . "');";
    if ($redirectUrl) {
        echo "window.location.href = '" . addslashes($redirectUrl) . "';";
    }
    echo "</script>";
    exit();
}
