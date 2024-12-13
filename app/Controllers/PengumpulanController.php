<?php
// app/controllers/PengumpulanController.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Sertakan file yang diperlukan
include_once __DIR__ . '/../core/Database.php';
include_once __DIR__ . '/../models/FileUpload.php';

class PengumpulanController {
    private $db;
    private $fileUploadModel;
    private $nim_mhs;

    public function __construct() {
        // Inisialisasi Database
        $database = new Database();
        $this->db = $database->dbh;

        // Inisialisasi Model FileUpload dengan koneksi database
        $this->fileUploadModel = new FileUpload($this->db);

        // Ambil NIM dari session
        session_start();
        if (isset($_SESSION['nim'])) {
            $this->nim_mhs = $_SESSION['nim'];
        } else {
            // Jika tidak ada session, redirect ke login atau tampilkan error
            header("Location: ../index.html");
            exit();
        }
    }

    public function uploadFile() {
        $basePath = '/project_web_bebas_tanggungan';
        // Cek tipe upload dari form
        if (isset($_POST['type'])) {
            $type = $_POST['type'];
        } else {
            // Jika tipe tidak ditentukan, redirect dengan error
            header("Location: /public/User/upload.php?error=invalid_type");
            exit();
        }

        // Mapping berdasarkan tipe upload
        $formToBerkasMap = [];
        $maxFileSize = 10 * 1024 * 1024; // 10 MB per file
        $allowedTypes = ['application/pdf'];
        $uploadDir = __DIR__ . '/../uploads/';

        if ($type === 'jurusan') {
            $formToBerkasMap = [
                'file_upload_1' => 1, 
                'file_upload_2' => 2,
                'file_upload_3' => 3,
            ];
        } elseif ($type === 'prodi') {
            $formToBerkasMap = [
                'file_upload_1' => 4,
                'file_upload_2' => 5,
                'file_upload_3' => 6,
                'file_upload_4' => 7,
            ];
        } elseif ($type === 'bebasAkademikPusat') {
            $formToBerkasMap = [
                'file_upload_1' => 1003, // Ganti dengan id_berkas yang sesuai untuk Bebas Akademik Pusat
            ];
        } elseif ($type === 'bebasPustaka') {
            $formToBerkasMap = [
                'file_upload_1' => 1004, // Ganti dengan id_berkas yang sesuai untuk Bebas Pustaka
            ];
        } else {
            // Tipe upload tidak dikenali
            header("Location: /public/User/upload.php?error=unknown_type");
            exit();
        }

        $allSuccess = true;

        // Pastikan direktori upload ada
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                header("Location: /public/User/upload.php?error=mkdir_failed");
                exit();
            }
        }

        // Loop untuk menangani setiap file input
        foreach ($formToBerkasMap as $formName => $id_berkas) {
            // Cek apakah file ada dan tidak ada error
            if (isset($_FILES[$formName]) && $_FILES[$formName]['error'] == 0) {
                $file = $_FILES[$formName];

                // Validasi ukuran file
                if ($file['size'] > $maxFileSize) {
                    $allSuccess = false;
                    // Redirect dengan error ukuran file
                    header("Location: /public/User/upload.php?error=size");
                    exit();
                }

                // Cek tipe file (hanya PDF yang diperbolehkan)
                if (!in_array($file['type'], $allowedTypes)) {
                    $allSuccess = false;
                    // Redirect dengan error tipe file
                    header("Location: /public/User/upload.php?error=type");
                    exit();
                }

                // Generate nama file unik
                $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $fileName = uniqid('file_') . '.' . strtolower($fileExtension);
                $filePath = $uploadDir . $fileName;

                // Pindahkan file ke direktori tujuan
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    // Simpan informasi file ke database melalui FileUpload model
                    if (!$this->fileUploadModel->saveFile($this->nim_mhs, $id_berkas, $file['name'], $file['type'], $file['size'], $filePath)) {
                        $allSuccess = false;
                        // Log atau tangani error penyimpanan file
                        header("Location: /public/User/upload.php?error=upload_failed");
                        exit();
                    }
                } else {
                    $allSuccess = false;
                    // Redirect dengan error gagal memindahkan file
                    header("Location: /public/User/upload.php?error=move_failed");
                    exit();
                }
            } else {
                // File tidak diupload atau terjadi error
                $allSuccess = false;
                header("Location: /public/User/upload.php?error=upload_error");
                exit();
            }
        }

        // Mapping type ke halaman redirect yang sesuai
        $typeRedirectMap = [
            'jurusan' => 'pengumpulanJurusan.php',
            'prodi' => 'pengumpulanProdi.php',
            'bebasAkademikPusat' => 'bebasAkademikPusat.php',
            'bebasPustaka' => 'bebasPustaka.php',
        ];

        // Redirect dengan status sesuai hasil
        if ($allSuccess) {
            header("Location: {$basePath}/public/User/" . $typeRedirectMap[$type] . "?success");
        } else {
            header("Location: {$basePath}/public/User/" . $typeRedirectMap[$type] . "?error=upload_failed");
        }
        exit();
    }
}

// Panggil fungsi upload
$controller = new PengumpulanController();
$controller->uploadFile();
?>
