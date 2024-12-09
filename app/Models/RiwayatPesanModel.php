<?php
// app/models/RiwayatPesanModel.php

class RiwayatPesanModel {
    private $db; // Properti untuk menyimpan instance PDO

    public function __construct($db) {
        $this->db = $db;
    }

    public function getRiwayatPesanByNIM($nim) {
        // Sertakan skema 'dbo' sebelum nama tabel jika diperlukan
        $sql = "SELECT tanggal, pesan_mhs as message, 
                'Pertanyaan Anda' as title 
                FROM dbo.riwayat_pesan 
                WHERE nim_mhs = :nim 
                ORDER BY tanggal DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nim', $nim, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertPesan($data)
    {
        // Sertakan skema 'dbo' sebelum nama tabel jika diperlukan
        $sql = "INSERT INTO dbo.riwayat_pesan (tujuan_id_jabatan, nim_mhs, pesan_mhs) 
                VALUES (:tujuan_id_jabatan, :nim_mhs, :pesan_mhs)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':tujuan_id_jabatan', $data['tujuan_id_jabatan'], PDO::PARAM_INT);
        $stmt->bindParam(':nim_mhs', $data['nim_mhs'], PDO::PARAM_STR);
        $stmt->bindParam(':pesan_mhs', $data['pesan_mhs'], PDO::PARAM_STR);
        return $stmt->execute();
    }
}
?>
