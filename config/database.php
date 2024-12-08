<?php
$servername = "GABRIELLOQ";
$uid = ""; // masukkan username di sini
$password = ""; // masukkan password di sini
$database = "pbl"; // nama database yang digunakan

// Konfigurasi koneksi
$connection = [
    "Database" => $database,
    "UID" => $uid,
    "PWD" => $password,
    "Encrypt" => "Optional", // Atur enkripsi menjadi opsional atau 'No' jika tidak ingin enkripsi
    "TrustServerCertificate" => true // Opsi jika sertifikat tidak tepercaya
];

// Mencoba menghubungkan ke server SQL
$conn = sqlsrv_connect($servername, $connection);

// Mengecek koneksi
if (!$conn) {
    die(print_r(sqlsrv_errors(), true)); // Menampilkan pesan error jika koneksi gagal
} else {
    echo 'Koneksi berhasil'; // Pesan jika koneksi berhasil
    echo '<br>';
}
?>