<?php
session_start();

// Daftar pengguna valid (username => password)
$valid_users = [
    'admin' => 'admin123',
    'admin2' => 'admin123',
    'GabrielBatavia' => '2341720184',
    'mahasiswa2' => 'studentpass2'
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek kredensial
    if (array_key_exists($username, $valid_users) && $valid_users[$username] == $password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        // Set NIM berdasarkan username (contoh hardcoded)
        if ($username == 'GabrielBatavia') {
            $_SESSION['nim'] = '1000001';
        } elseif ($username == 'mahasiswa2') {
            $_SESSION['nim'] = '1000002';
        }

        if ($username == 'admin') {
            $_SESSION['id_jabatan'] = '1';
        } elseif ($username == 'admin2') {
            $_SESSION['id_jabatan'] = '2';
        }

        // Redirect berdasarkan peran
        if ($username == 'admin') {
            header("Location: Admin/dashboard.php");
        } else {
            header("Location: User/dashboard.php");
        }
        exit;
    } else {
        echo "<script>alert('Username atau password salah!'); window.location.href='index.html';</script>";
    }
}
?>
