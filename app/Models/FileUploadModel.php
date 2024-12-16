<?php
// app/models/FileUploadModel.php

class FileUploadModel
{
    private $db;

    /**
     * Konstruktor menerima instance PDO dari Controller
     *
     * @param PDO $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Mendapatkan file upload berdasarkan id_tanggungan
    public function getFilesByTanggungan($id_tanggungan)
    {
        $sql = "SELECT * FROM fileupload WHERE id_tanggungan = :id_tanggungan";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_tanggungan', $id_tanggungan);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        // **Baru: Mendapatkan file upload berdasarkan id_file**
        public function getFileById($id_file)
        {
            $sql = "SELECT * FROM fileupload WHERE id_file = :id_file";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_file', $id_file, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
}
?>
