<?php
session_start();
require_once '../app/Controllers/LoginController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Instantiate the LoginController
    $loginController = new LoginController();
    $loginController->authenticate($username, $password);
}
