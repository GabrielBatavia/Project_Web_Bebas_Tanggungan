<?php
class FileUpload {
    private $db;

    public function __construct() {
        // Koneksi ke database menggunakan properti $dbh
        $database = new Database();
        $this->db = $database->dbh;
    }

    public function saveFile($idTanggungan, $fileName, $fileType, $fileSize, $filePath) {
        $query = "INSERT INTO fileupload (id_tanggungan, file_path, nama_file, tipe_file, ukuran_file, tanggal_upload)
                  VALUES (:id_tanggungan, :file_path, :nama_file, :tipe_file, :ukuran_file, NOW())";
    
        // Menyiapkan statement
        $stmt = $this->db->prepare($query);
    
        // Bind data ke parameter
        $stmt->bindParam(':id_tanggungan', $idTanggungan, PDO::PARAM_INT);
        $stmt->bindParam(':file_path', $filePath, PDO::PARAM_STR);  // Menyimpan path file, bukan isi file
        $stmt->bindParam(':nama_file', $fileName, PDO::PARAM_STR);
        $stmt->bindParam(':tipe_file', $fileType, PDO::PARAM_STR);
        $stmt->bindParam(':ukuran_file', $fileSize, PDO::PARAM_INT);
    
        // Eksekusi query
        if ($stmt->execute()) {
            // Log sukses
            error_log("SUCCESS: File '$fileName' dengan path '$filePath' berhasil disimpan ke database.\n", 3, __DIR__ . '/../../logs/upload.log');
            return true;
        } else {
            // Log gagal
            $errorInfo = $stmt->errorInfo();
            error_log("ERROR: Gagal menyimpan file '$fileName' ke database. Error: " . $errorInfo[2] . "\n", 3, __DIR__ . '/../../logs/upload.log');
            return false;
        }
    }
}
?>
