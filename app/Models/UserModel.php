<?php
// app/models/UserModel.php

require_once __DIR__ . '/../core/Database.php';

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Mendapatkan total pengguna
    public function getTotalUsers()
    {
        $this->db->query("SELECT COUNT(*) as total FROM mahasiswa");
        $result = $this->db->single();
        return $result['total'];
    }
}
?>
