<?php
// app/models/KomentarModel.php

require_once __DIR__ . '/../core/Database.php';

class KomentarModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Menambahkan komentar
    public function addKomentar($id_tanggungan, $id_verifikator, $komentar)
    {
        $this->db->query("
            INSERT INTO komentar (id_tanggungan, id_verifikator, komentar)
            VALUES (:id_tanggungan, :id_verifikator, :komentar)
        ");
        $this->db->bind(':id_tanggungan', $id_tanggungan);
        $this->db->bind(':id_verifikator', $id_verifikator);
        $this->db->bind(':komentar', $komentar);
        return $this->db->execute();
    }
}
?>
