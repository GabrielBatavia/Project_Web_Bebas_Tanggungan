<?php
class Tanggungan {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable error handling
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
}
?>
