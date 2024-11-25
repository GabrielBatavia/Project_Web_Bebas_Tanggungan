<?php
class Berkas {
    private $conn;
    private $table = 'berkas';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllBerkas() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
