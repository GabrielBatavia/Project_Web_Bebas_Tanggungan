<?php
session_start();
require_once '../app/core/Database.php';

// Instantiate the database connection
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $queryMahasiswa = "SELECT * FROM mahasiswa WHERE nim = :username AND password = :password";
    $db->query($queryMahasiswa);
    $db->bind(':username', $username);
    $db->bind(':password', $password);
    $mahasiswa = $db->single();

    if ($mahasiswa) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $mahasiswa['nama'];
        $_SESSION['nim'] = $mahasiswa['nim'];
        $_SESSION['role'] = 'mahasiswa';

        header("Location: User/dashboard.php");
        exit;
    }

    $queryVerifikator = "SELECT * FROM verifikator WHERE nip = :username AND password = :password";
    $db->query($queryVerifikator);
    $db->bind(':username', $username);
    $db->bind(':password', $password);
    $verifikator = $db->single();

    if ($verifikator) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $verifikator['nama'];
        $_SESSION['nip'] = $verifikator['nip'];
        $_SESSION['role'] = 'verifikator';
        $_SESSION['id_jabatan'] = $verifikator['id_jabatan'];

        header("Location: Admin/dashboard.php");
        exit;
    }

    // Login failed
    echo "<script>alert('Username atau password salah!'); window.location.href='index.html';</script>";
}
?>
