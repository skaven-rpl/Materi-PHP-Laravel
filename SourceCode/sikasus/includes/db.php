<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "db_sekolah";

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Mengecek apakah koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
