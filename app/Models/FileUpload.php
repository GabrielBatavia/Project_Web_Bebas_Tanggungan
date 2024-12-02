<?php
class FileUpload {
    private $db;

    public function __construct() {
        // Koneksi ke database menggunakan metode connect()
        $database = new Database();
        $this->db = $database->connect();
    }

    public function saveFile($fileName, $fileType, $fileSize, $filePath) {
        $query = "INSERT INTO fileupload (id_tanggungan, file_path, nama_file, tipe_file, ukuran_file, tanggal_upload)
                  VALUES (:id_tanggungan, :file_path, :nama_file, :tipe_file, :ukuran_file, NOW())";
    
        // Menyiapkan statement
        $stmt = $this->db->prepare($query);
    
        // Bind data ke parameter
        $stmt->bindParam(':id_tanggungan', $_POST['id_tanggungan'], PDO::PARAM_INT);
        $stmt->bindParam(':file_path', $filePath, PDO::PARAM_STR);  // Menyimpan path file, bukan isi file
        $stmt->bindParam(':nama_file', $fileName, PDO::PARAM_STR);
        $stmt->bindParam(':tipe_file', $fileType, PDO::PARAM_STR);
        $stmt->bindParam(':ukuran_file', $fileSize, PDO::PARAM_INT);
    
        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
