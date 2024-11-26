<?php
class Pengumpulan
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function uploadFile($id_tanggungan, $nama_file, $tipe_file, $ukuran_file, $file_upload)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO fileupload (id_tanggungan, nama_file, tipe_file, ukuran_file, file_upload) 
                                        VALUES (:id_tanggungan, :nama_file, :tipe_file, :ukuran_file, :file_upload)");
            $stmt->bindParam(':id_tanggungan', $id_tanggungan);
            $stmt->bindParam(':nama_file', $nama_file);
            $stmt->bindParam(':tipe_file', $tipe_file);
            $stmt->bindParam(':ukuran_file', $ukuran_file);
            $stmt->bindParam(':file_upload', $file_upload, PDO::PARAM_LOB);

            if ($stmt->execute()) {
                $this->updateTanggunganStatus($id_tanggungan, 'Selesai');
                return true;
            }
            return false;
        } catch (PDOException $e) {
            throw new Exception("Error uploading file: " . $e->getMessage());
        }
    }

    public function updateTanggunganStatus($id_tanggungan, $status)
    {
        try {
            $stmt = $this->db->prepare("UPDATE tanggungan SET status = :status WHERE id_tanggungan = :id_tanggungan");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id_tanggungan', $id_tanggungan);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error updating status: " . $e->getMessage());
        }
    }
}
?>
