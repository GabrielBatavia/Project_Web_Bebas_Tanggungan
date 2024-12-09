<?php
// app/models/UserModel.php

class UserModel
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

    // Mendapatkan total pengguna
    public function getTotalUsers()
    {
        $sql = "SELECT COUNT(*) as total FROM mahasiswa";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
?>
