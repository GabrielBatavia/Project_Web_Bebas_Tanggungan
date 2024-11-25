<?php
class Mahasiswa {
    private $conn;
    private $table = 'mahasiswa';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getMahasiswaById($nim) {
        $query = "SELECT * FROM " . $this->table . " WHERE nim = :nim";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nim', $nim);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
