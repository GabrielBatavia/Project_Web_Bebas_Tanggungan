<?php
// app/models/TanggunganModel.php

class TanggunganModel
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

    // Mendapatkan jumlah verifikasi berkas berdasarkan jabatan
    public function getVerifBerkasCount($id_jabatan)
    {
        $sql = "
            SELECT COUNT(*) as total 
            FROM tanggungan t
            INNER JOIN berkas b ON t.id_berkas = b.id_berkas
            WHERE b.id_jabatan = :id_jabatan 
              AND t.status IN ('Belum', 'Dibaca')
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_jabatan', $id_jabatan);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Mendapatkan jumlah berkas selesai berdasarkan jabatan
    public function getBerkasSelesaiCount($id_jabatan)
    {
        $sql = "
            SELECT COUNT(*) as total 
            FROM tanggungan t
            INNER JOIN berkas b ON t.id_berkas = b.id_berkas
            WHERE b.id_jabatan = :id_jabatan 
              AND t.status = 'Selesai'
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_jabatan', $id_jabatan);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Metode untuk mengambil file berdasarkan NIM dan Jabatan
    public function getFilesByNIMAndJabatan($nim, $id_jabatan)
    {
        $sql = "
            SELECT fu.id_file, fu.id_tanggungan, fu.file_path, fu.nama_file, fu.tipe_file, fu.ukuran_file, fu.tanggal_upload, 
                   t.status
            FROM fileupload fu
            JOIN tanggungan t ON fu.id_tanggungan = t.id_tanggungan
            JOIN berkas b ON t.id_berkas = b.id_berkas
            WHERE t.nim_mhs = :nim AND b.id_jabatan = :id_jabatan
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nim', $nim);
        $stmt->bindParam(':id_jabatan', $id_jabatan);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengupdate status dan catatan
    public function updateStatus($id_tanggungan, $status)
    {
        $sql = "
            UPDATE tanggungan
            SET status = :status
            WHERE id_tanggungan = :id_tanggungan
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id_tanggungan', $id_tanggungan);
        return $stmt->execute();
    }
}
?>
