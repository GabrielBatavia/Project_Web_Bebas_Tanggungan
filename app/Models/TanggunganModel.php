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

        // Mengambil semua berkas berdasarkan NIM dan id_jabatan
        public function getFilesByNIMAndJabatan($nim, $id_jabatan)
        {
            $this->db->query("
                SELECT t.id_tanggungan, t.status, t.nim_mhs, b.nama_berkas, f.file_path, f.nama_file
                FROM tanggungan t
                INNER JOIN berkas b ON t.id_berkas = b.id_berkas
                INNER JOIN fileupload f ON t.id_tanggungan = f.id_tanggungan
                WHERE t.nim_mhs = :nim
                  AND b.id_jabatan = :id_jabatan
            ");
            $this->db->bind(':nim', $nim);
            $this->db->bind(':id_jabatan', $id_jabatan);
            return $this->db->resultSet();
        }
    
        // Mengupdate status dan catatan
        public function updateStatus($id_tanggungan, $status)
        {
            $this->db->query("
                UPDATE tanggungan
                SET status = :status
                WHERE id_tanggungan = :id_tanggungan
            ");
            $this->db->bind(':status', $status);
            $this->db->bind(':id_tanggungan', $id_tanggungan);
            return $this->db->execute();
        }
}
?>
