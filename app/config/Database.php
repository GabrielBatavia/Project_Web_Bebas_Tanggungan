<?php
// app/config/Database.php

$servername = "GABRIELLOQ"; // Nama server SQL Server Anda
$uid = ""; // Masukkan username SQL Server Anda
$password = ""; // Masukkan password SQL Server Anda
$database = "pbl"; // Nama database yang digunakan

// Konfigurasi koneksi
$connection = [
    "Database" => $database,
    "UID" => $uid,
    "PWD" => $password,
    "Encrypt" => "Optional", // Atur enkripsi menjadi 'Optional' atau 'No' jika tidak ingin enkripsi
    "TrustServerCertificate" => true // Opsi jika sertifikat tidak tepercaya
];

// Mencoba menghubungkan ke server SQL
$conn = sqlsrv_connect($servername, $connection);

// Mengecek koneksi
if (!$conn) {
    die(print_r(sqlsrv_errors(), true)); // Menampilkan pesan error jika koneksi gagal
} else {
    echo 'Koneksi berhasil';
    echo '<br>';
}
?>
