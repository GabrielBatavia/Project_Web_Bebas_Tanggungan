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
        // Mapping dari nama input file ke id_berkas
        $formToBerkasMap = [
            'file_upload_1' => 1, // Sesuaikan dengan id_berkas yang sebenarnya
            'file_upload_2' => 2,
            'file_upload_3' => 3,
        ];

        $maxFileSize = 10 * 1024 * 1024; // 10 MB
        $uploadDir = __DIR__ . '/../uploads/';
        $allSuccess = true;

        // Pastikan direktori upload ada
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                header("Location: /public/pengumpulanJurusan.php?error=mkdir_failed");
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
                    header("Location: /public/pengumpulanJurusan.php?error=size");
                    exit();
                }

                // Cek tipe file (hanya PDF yang diperbolehkan)
                $allowedTypes = ['application/pdf'];
                if (!in_array($file['type'], $allowedTypes)) {
                    $allSuccess = false;
                    // Redirect dengan error tipe file
                    header("Location: /public/pengumpulanJurusan.php?error=type");
                    exit();
                }

                // Generate nama file unik
                $fileName = uniqid('file_') . '.pdf';
                $filePath = $uploadDir . $fileName;

                // Pindahkan file ke direktori tujuan
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    // Simpan informasi file ke database melalui FileUpload model
                    if (!$this->fileUploadModel->saveFile($this->nim_mhs, $id_berkas, $file['name'], $file['type'], $file['size'], $filePath)) {
                        $allSuccess = false;
                        // Log atau tangani error penyimpanan file
                        header("Location: /public/pengumpulanJurusan.php?error=upload_failed");
                        exit();
                    }
                } else {
                    $allSuccess = false;
                    // Redirect dengan error gagal memindahkan file
                    header("Location: /public/pengumpulanJurusan.php?error=move_failed");
                    exit();
                }
            } else {
                // File tidak diupload atau terjadi error
                // Anda dapat memilih untuk mengabaikan atau menandai sebagai gagal
                // Di sini kita memilih untuk menandai sebagai gagal
                $allSuccess = false;
                header("Location: /public/pengumpulanJurusan.php?error=upload_error");
                exit();
            }
        }

        // Redirect dengan status sesuai hasil
        if ($allSuccess) {
            header("Location: /public/pengumpulanJurusan.php?success");
        } else {
            header("Location: /public/pengumpulanJurusan.php?error=upload_failed");
        }
        exit();
    }
}

// Panggil fungsi upload
$controller = new PengumpulanController();
$controller->uploadFile();
?>
