<?php
// app/models/KomentarModel.php

class KomentarModel
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

    // Menambahkan komentar
    public function addKomentar($id_tanggungan, $id_verifikator, $komentar)
    {
        $sql = "
            INSERT INTO komentar (id_tanggungan, id_verifikator, komentar)
            VALUES (:id_tanggungan, :id_verifikator, :komentar)
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_tanggungan', $id_tanggungan);
        $stmt->bindParam(':id_verifikator', $id_verifikator);
        $stmt->bindParam(':komentar', $komentar);
        return $stmt->execute();
    }
}
?>
