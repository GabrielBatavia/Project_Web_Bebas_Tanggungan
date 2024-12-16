<?php
// public/Admin/servePdf.php

// Mulai sesi dan periksa apakah admin sudah login
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("HTTP/1.0 403 Forbidden");
    exit('Akses ditolak.');
}

// Periksa apakah parameter id_file ada dan valid
if (!isset($_GET['id_file']) || !is_numeric($_GET['id_file'])) {
    header("HTTP/1.0 400 Bad Request");
    exit('Permintaan tidak valid.');
}

$id_file = intval($_GET['id_file']);

// Sertakan controller atau model untuk mengambil data file dari database
require_once __DIR__ . '/../../app/controllers/CekVerifyController.php';

$cekVerifyController = new CekVerifyController();
$fileData = $cekVerifyController->getFileById($id_file);

if (!$fileData) {
    header("HTTP/1.0 404 Not Found");
    exit('File tidak ditemukan.');
}

$filePath = $fileData['file_path'];

// Verifikasi apakah file benar-benar ada
if (!file_exists($filePath)) {
    header("HTTP/1.0 404 Not Found");
    exit('File tidak ditemukan di server.');
}

// Set header yang sesuai untuk menyajikan PDF
header('Content-Type: ' . $fileData['tipe_file']);
header('Content-Disposition: inline; filename="' . basename($fileData['nama_file']) . '"');
header('Content-Length: ' . filesize($filePath));

// Sajikan file PDF
readfile($filePath);
exit;
?>
