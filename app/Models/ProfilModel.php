<?php
class ProfilModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getMahasiswaByNIM($nim) {
        $this->db->query("SELECT * FROM mahasiswa WHERE nim = :nim");
        $this->db->bind(':nim', $nim);
        return $this->db->single();
    }
}
