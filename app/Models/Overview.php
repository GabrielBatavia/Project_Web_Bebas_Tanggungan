<?php
class Overview {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable error handling
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
