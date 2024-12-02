<?php
include_once __DIR__ . '/../../config/Database.php';
include_once __DIR__ . '/../models/FileUpload.php';

class PengumpulanController {
    public function uploadFile() {
        $forms = ['file_upload_1', 'file_upload_2', 'file_upload_3', 'file_upload_4']; // ID dari setiap input file di form
        $maxFileSize = 10 * 1024 * 1024; // 10 MB
    
        // Loop untuk menangani setiap file input
        foreach ($forms as $form) {
            // Cek apakah file ada dan tidak ada error
            if (isset($_FILES[$form]) && $_FILES[$form]['error'] == 0) {
                $file = $_FILES[$form];
    
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
                    if (!$fileUpload->saveFile($_POST['id_tanggungan'], $file['name'], $file['type'], $file['size'], $filePath)) {
                        header("Location: /public/pengumpulanJurusan.php?error=database_error");
                        exit();
                    }
                } else {
                    // Redirect dengan status error jika gagal upload
                    header("Location: /public/pengumpulanJurusan.php?error=upload_failed");
                    exit();
                }
            }
        }
    
        // Redirect dengan status success jika semua file berhasil di-upload
        header("Location: /public/pengumpulanJurusan.php?success");
        exit();
    }
}

// Panggil fungsi upload
$controller = new PengumpulanController();
$controller->uploadFile();
?>
