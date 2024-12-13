<?php
// app/models/Tanggungan.php

class Tanggungan {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        // Tidak perlu lagi memanggil setAttribute karena sudah diatur di Database.php
    }

    // Mengambil semua tanggungan (digunakan oleh admin)
    public function getAllTanggungan() {
        $query = "SELECT 
                    t.id_tanggungan, 
                    t.nim_mhs,
                    m.nama as nama_mahasiswa,
                    b.nama_berkas, 
                    b.deskripsi, 
                    t.status
                  FROM tanggungan t
                  JOIN berkas b ON t.id_berkas = b.id_berkas
                  JOIN mahasiswa m ON t.nim_mhs = m.nim";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil tanggungan berdasarkan NIM (digunakan oleh mahasiswa)
    public function getTanggunganByNIM($nim) {
        $query = "SELECT 
                    t.id_tanggungan, 
                    b.nama_berkas, 
                    b.deskripsi, 
                    t.status
                  FROM tanggungan t
                  JOIN berkas b ON t.id_berkas = b.id_berkas
                  WHERE t.nim_mhs = :nim";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nim', $nim, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFilteredTanggunganByNIM($nim) {
        $query = "
            SELECT 
                b.id_berkas, 
                b.nama_berkas, 
                b.deskripsi,
                CASE 
                    WHEN t.status IS NULL THEN 'belum dikirim'
                    ELSE t.status
                END AS status
            FROM berkas b
            LEFT JOIN tanggungan t 
                ON b.id_berkas = t.id_berkas 
                AND t.nim_mhs = :nim
            WHERE b.id_berkas BETWEEN 1 AND 7
              AND (t.status IS NULL OR (t.status <> 'selesai' AND t.status <> 'pending'))
            ORDER BY b.id_berkas ASC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nim', $nim, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    
        // Mengambil semua berkas berdasarkan NIM dan id_jabatan
        public function getFilesByNIMAndJabatan($nim, $id_jabatan)
        {
            $sql = "
                SELECT t.id_tanggungan, t.status, t.nim_mhs, b.nama_berkas, f.file_path, f.nama_file
                FROM tanggungan t
                INNER JOIN berkas b ON t.id_berkas = b.id_berkas
                INNER JOIN fileupload f ON t.id_tanggungan = f.id_tanggungan
                WHERE t.nim_mhs = :nim
                  AND b.id_jabatan = :id_jabatan
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
