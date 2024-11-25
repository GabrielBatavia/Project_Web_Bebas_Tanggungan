<?php
class Tanggungan {
    private $conn;
    private $table = 'tanggungan';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getBelumSelesaiTanggungan() {
        $query = "SELECT 
                    t.id_tanggungan,
                    b.nama_berkas,
                    CONCAT('Upload ', b.nama_berkas) AS deskripsi,
                    t.status
                 FROM 
                    tanggungan t
                 JOIN 
                    berkas b ON t.id_berkas = b.id_berkas
                 WHERE 
                    t.status = 'Belum Selesai'
                 ORDER BY 
                    t.id_tanggungan ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>