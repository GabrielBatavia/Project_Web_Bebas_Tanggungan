<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . '/../core/Database.php';
include_once __DIR__ . '/../models/FileUpload.php';

class PengumpulanController {
    public function uploadFile() {
        $forms = ['file_upload_1', 'file_upload_2', 'file_upload_3']; // ID dari setiap input file di form
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
        foreach ($forms as $form) {
            // Cek apakah file ada dan tidak ada error
            if (isset($_FILES[$form]) && $_FILES[$form]['error'] == 0) {
                $file = $_FILES[$form];

                // Validasi ukuran file
                if ($file['size'] > $maxFileSize) {
                    $allSuccess = false;
                    continue; // Lewati ke file berikutnya
                }

                // Cek tipe file (hanya PDF yang diperbolehkan)
                $allowedTypes = ['application/pdf'];
                if (!in_array($file['type'], $allowedTypes)) {
                    $allSuccess = false;
                    continue; // Lewati ke file berikutnya
                }

                // Generate nama file unik
                $fileName = uniqid('file_') . '.pdf';
                $filePath = $uploadDir . $fileName;

                // Pindahkan file ke direktori tujuan
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    // Simpan informasi file ke database
                    $fileUpload = new FileUpload();
                    if (!$fileUpload->saveFile($_POST['id_tanggungan'], $file['name'], $file['type'], $file['size'], $filePath)) {
                        $allSuccess = false;
                        continue; // Lewati ke file berikutnya
                    }
                } else {
                    $allSuccess = false;
                    continue; // Lewati ke file berikutnya
                }
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
