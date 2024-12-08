<?php
// app/models/MahasiswaModel.php

require_once __DIR__ . '/../core/Database.php';

class MahasiswaModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Mendapatkan data mahasiswa berdasarkan jabatan
    public function getMahasiswaByJabatan($id_jabatan)
    {
        $this->db->query("
            SELECT m.nim, m.nama, m.no_telepon, t.status, b.deadline,
                   CASE 
                       WHEN b.deadline < CURDATE() THEN 'Tinggi'
                       WHEN b.deadline BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 'Sedang'
                       ELSE 'Ringan'
                   END AS urgensi
            FROM mahasiswa m
            INNER JOIN tanggungan t ON m.nim = t.nim_mhs
            INNER JOIN berkas b ON t.id_berkas = b.id_berkas
            WHERE b.id_jabatan = :id_jabatan
        ");
        $this->db->bind(':id_jabatan', $id_jabatan);
        return $this->db->resultSet();
    }

    public function getMahasiswaByNIM($nim)
    {
        $this->db->query("SELECT * FROM mahasiswa WHERE nim = :nim");
        $this->db->bind(':nim', $nim);
        return $this->db->single();
    }
}
?>
