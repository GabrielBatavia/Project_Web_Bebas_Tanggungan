<?php
// app/models/TanggunganModel.php

require_once __DIR__ . '/../core/Database.php';

class TanggunganModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Mendapatkan jumlah verifikasi berkas berdasarkan jabatan
    public function getVerifBerkasCount($id_jabatan)
    {
        $this->db->query("
            SELECT COUNT(*) as total 
            FROM tanggungan t
            INNER JOIN berkas b ON t.id_berkas = b.id_berkas
            WHERE b.id_jabatan = :id_jabatan 
            AND t.status IN ('Belum', 'Dibaca')
        ");
        $this->db->bind(':id_jabatan', $id_jabatan);
        $result = $this->db->single();
        return $result['total'];
    }

    // Mendapatkan jumlah berkas selesai berdasarkan jabatan
    public function getBerkasSelesaiCount($id_jabatan)
    {
        $this->db->query("
            SELECT COUNT(*) as total 
            FROM tanggungan t
            INNER JOIN berkas b ON t.id_berkas = b.id_berkas
            WHERE b.id_jabatan = :id_jabatan 
            AND t.status = 'Selesai'
        ");
        $this->db->bind(':id_jabatan', $id_jabatan);
        $result = $this->db->single();
        return $result['total'];
    }
}
?>
