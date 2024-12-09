<?php
// app/models/FileUpload.php

class FileUpload {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Create a new tanggungan entry for a given nim_mhs and id_berkas
     *
     * @param string $nim_mhs
     * @param int $id_berkas
     * @return mixed id_tanggungan jika berhasil, false jika gagal
     */
    private function createTanggungan($nim_mhs, $id_berkas) {
        // Mulai transaksi
        $this->db->beginTransaction();
        try {
            // Buat tanggungan baru dengan status 'pending'
            $insertQuery = "INSERT INTO tanggungan (nim_mhs, id_berkas, status) VALUES (:nim, :id_berkas, 'pending')";
            $insertStmt = $this->db->prepare($insertQuery);
            $insertStmt->bindParam(':nim', $nim_mhs, PDO::PARAM_STR);
            $insertStmt->bindParam(':id_berkas', $id_berkas, PDO::PARAM_INT);
            $insertStmt->execute();
            $id_tanggungan = $this->db->lastInsertId();

            // Commit transaksi
            $this->db->commit();

            // Log sukses
            error_log("ID Tanggungan Baru: $id_tanggungan untuk NIM: $nim_mhs dan ID Berkas: $id_berkas\n", 3, __DIR__ . '/../../logs/upload.log');

            return $id_tanggungan;
        } catch (PDOException $e) {
            // Rollback transaksi jika terjadi error
            $this->db->rollBack();
            // Log exception
            error_log("EXCEPTION: " . $e->getMessage() . "\n", 3, __DIR__ . '/../../logs/upload.log');
            return false;
        }
    }

    /**
     * Menyimpan informasi file ke tabel fileupload
     * 
     * @param string $nim_mhs
     * @param int $id_berkas
     * @param string $fileName
     * @param string $fileType
     * @param int $fileSize
     * @param string $filePath
     * @return bool
     */
    public function saveFile($nim_mhs, $id_berkas, $fileName, $fileType, $fileSize, $filePath) {
        // Buat tanggungan baru
        $id_tanggungan = $this->createTanggungan($nim_mhs, $id_berkas);
        if ($id_tanggungan === false) {
            // Gagal membuat tanggungan
            return false;
        }

        // Insert ke tabel fileupload
        $query = "INSERT INTO fileupload (id_tanggungan, file_path, nama_file, tipe_file, ukuran_file, tanggal_upload)
                  VALUES (:id_tanggungan, :file_path, :nama_file, :tipe_file, :ukuran_file, GETDATE())";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_tanggungan', $id_tanggungan, PDO::PARAM_INT);
            $stmt->bindParam(':file_path', $filePath, PDO::PARAM_STR);
            $stmt->bindParam(':nama_file', $fileName, PDO::PARAM_STR);
            $stmt->bindParam(':tipe_file', $fileType, PDO::PARAM_STR);
            $stmt->bindParam(':ukuran_file', $fileSize, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Log sukses
                error_log("SUCCESS: File '$fileName' dengan path '$filePath' berhasil disimpan ke database dengan id_tanggungan $id_tanggungan.\n", 3, __DIR__ . '/../../logs/upload.log');
                return true;
            } else {
                // Log gagal
                $errorInfo = $stmt->errorInfo();
                error_log("ERROR: Gagal menyimpan file '$fileName' ke database. Error: " . $errorInfo[2] . "\n", 3, __DIR__ . '/../../logs/upload.log');
                return false;
            }
        } catch (PDOException $e) {
            // Log exception
            error_log("EXCEPTION: " . $e->getMessage() . "\n", 3, __DIR__ . '/../../logs/upload.log');
            return false;
        }
    }
}
?>
