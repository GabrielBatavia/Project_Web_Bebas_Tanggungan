<?php
session_start();

// Sample hardcoded users (you can replace this with a database query)
$valid_users = [
    'admin' => 'admin123',  // Admin user
    'GabrielBatavia' => '2341720184', // Example mahasiswa
    'mahasiswa2' => 'studentpass2'  // Another mahasiswa
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username exists and the password is correct
    if (array_key_exists($username, $valid_users) && $valid_users[$username] == $password) {
        // Set session variable
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        // Redirect based on the role of the user
        if ($username == 'admin') {
            header("Location: ./testAdmin/dashboard.html"); // Admin page
        } else {
            header("Location: dashboard.php"); // Student page
        }
        exit;
    } else {
        echo "<script>alert('Username atau password salah!'); window.location.href='index.html';</script>";
    }
}
?>
