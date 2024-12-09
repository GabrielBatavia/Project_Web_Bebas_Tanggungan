<?php
// app/models/ProfilModel.php

class ProfilModel
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

    public function getMahasiswaByNIM($nim)
    {
        $sql = "SELECT * FROM mahasiswa WHERE nim = :nim";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nim', $nim);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
