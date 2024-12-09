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
              AND (t.status IS NULL OR t.status <> 'selesai')
            ORDER BY b.id_berkas ASC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nim', $nim, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Metode tambahan jika diperlukan
}
?>
