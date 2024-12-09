<?php
// Aktifkan error reporting untuk debugging (hapus atau nonaktifkan di produksi)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload atau sertakan file yang diperlukan
include_once __DIR__ . '/../../config/Database.php';
include_once __DIR__ . '/../../app/models/FileUpload.php';
include_once __DIR__ . '/../../app/controllers/PengumpulanController.php';

// Buat instance controller dan panggil metode upload
$controller = new PengumpulanController();
$controller->uploadFile();
?>
