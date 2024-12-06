<?php
session_start();

// Sample hardcoded users (username => password)
$valid_users = [
    'admin' => 'admin123',
    'GabrielBatavia' => '2341720184',
    'mahasiswa2' => 'studentpass2'
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check credentials
    if (array_key_exists($username, $valid_users) && $valid_users[$username] == $password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        // Set nim based on username (contoh hardcoded)
        if ($username == 'GabrielBatavia') {
            $_SESSION['nim'] = '1000001';
        } else if ($username == 'mahasiswa2') {
            $_SESSION['nim'] = '1000002';
        }

        // Redirect based on role
        if ($username == 'admin') {
            header("Location: ./testAdmin/dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    } else {
        echo "<script>alert('Username atau password salah!'); window.location.href='index.html';</script>";
    }
}
?>
