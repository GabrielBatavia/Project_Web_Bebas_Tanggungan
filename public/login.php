<?php
session_start();
$valid_user = "admin";
$valid_pass = "password123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == $valid_user && $password == $valid_pass) {
        $_SESSION['loggedin'] = true;
        header("Location: dashboard.html");
        exit;
    } else {
        echo "<script>alert('Username atau password salah!'); window.location.href='index.html';</script>";
    }
}
?>
