<?php
// app/models/FileUploadModel.php

require_once __DIR__ . '/../core/Database.php';

class FileUploadModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Mendapatkan file upload berdasarkan id_tanggungan
    public function getFilesByTanggungan($id_tanggungan)
    {
        $this->db->query("SELECT * FROM fileupload WHERE id_tanggungan = :id_tanggungan");
        $this->db->bind(':id_tanggungan', $id_tanggungan);
        return $this->db->resultSet();
    }
}
?>
