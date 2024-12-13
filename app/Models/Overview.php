<?php
class Overview {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getSelesaiByNIM($nim) {
        $query = "SELECT 
                    t.id_tanggungan, 
                    b.nama_berkas, 
                    t.status
                  FROM tanggungan t
                  JOIN berkas b ON t.id_berkas = b.id_berkas
                  WHERE t.status = 'Selesai' AND t.nim_mhs = :nim";
        $this->conn->prepare($query);
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nim', $nim, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBelumSelesaiByNIM($nim) {
        $query = "SELECT 
                    t.id_tanggungan, 
                    b.nama_berkas, 
                    t.status
                  FROM tanggungan t
                  JOIN berkas b ON t.id_berkas = b.id_berkas
                  WHERE t.status = 'Ditolak' AND t.nim_mhs = :nim";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nim', $nim, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingByNIM($nim) {
        $query = "SELECT 
                    t.id_tanggungan, 
                    b.nama_berkas, 
                    t.status
                  FROM tanggungan t
                  JOIN berkas b ON t.id_berkas = b.id_berkas
                  WHERE t.status = 'Pending' AND t.nim_mhs = :nim";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nim', $nim, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getSelesai() {
        $query = "SELECT 
                    t.id_tanggungan, 
                    b.nama_berkas, 
                    t.status
                  FROM tanggungan t
                  JOIN berkas b ON t.id_berkas = b.id_berkas
                  WHERE t.status = 'Selesai'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBelumSelesai() {
        $query = "SELECT 
                    t.id_tanggungan, 
                    b.nama_berkas, 
                    t.status
                  FROM tanggungan t
                  JOIN berkas b ON t.id_berkas = b.id_berkas
                  WHERE t.status = 'Belum Selesai'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPending() {
        $query = "SELECT 
                    t.id_tanggungan, 
                    b.nama_berkas, 
                    t.status
                  FROM tanggungan t
                  JOIN berkas b ON t.id_berkas = b.id_berkas
                  WHERE t.status = 'Pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
