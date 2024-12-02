<?php
include_once __DIR__ . '/../../config/Database.php';
include_once __DIR__ . '/../models/FileUpload.php';

class PengumpulanController {
    public function uploadFile() {
        // Cek apakah file sudah diupload
        if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == 0) {
            $file = $_FILES['file_upload'];
            $maxFileSize = 10 * 1024 * 1024; // 10 MB

            // Validasi ukuran file
            if ($file['size'] > $maxFileSize) {
                header("Location: /public/pengumpulanJurusan.php?error=size");
                exit();
            }

            // Cek tipe file (hanya PDF yang diperbolehkan)
            $allowedTypes = ['application/pdf'];
            if (!in_array($file['type'], $allowedTypes)) {
                header("Location: /public/pengumpulanJurusan.php?error=invalid_type");
                exit();
            }

            // Tentukan direktori tempat menyimpan file
            $uploadDir = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generate nama file unik
            $fileName = uniqid('file_') . '.pdf';
            $filePath = $uploadDir . $fileName;

            // Pindahkan file ke direktori tujuan
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                // Simpan informasi file ke database
                $fileUpload = new FileUpload();
                $fileUpload->saveFile($file['name'], $file['type'], $file['size'], $filePath);

                // Redirect dengan status success
                header("Location: /public/pengumpulanJurusan.php?success");
                exit();
            } else {
                // Redirect dengan status error
                header("Location: /public/pengumpulanJurusan.php?error=upload_failed");
                exit();
            }
        }
    }
}

// Panggil fungsi upload
$controller = new PengumpulanController();
$controller->uploadFile();
