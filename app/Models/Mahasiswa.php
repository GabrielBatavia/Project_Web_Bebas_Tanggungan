<?php
// Mahasiswa model content
class Mahasiswa {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }
    public function getMahasiswaById($studentId) {
        $query = "SELECT * FROM mahasiswa WHERE id = :studentId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':studentId', $studentId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateMahasiswa($data) {
        $query = "UPDATE mahasiswa SET name = :name, major = :major WHERE id = :studentId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':major', $data['major']);
        $stmt->bindParam(':studentId', $data['student_id']);
        return $stmt->execute();
    }
}