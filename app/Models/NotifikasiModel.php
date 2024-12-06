<?php
class NotifikasiModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getNotifikasiByNIM($nim) {
        // Contoh query untuk mendapatkan notifikasi (komentar) terkait mahasiswa
        // Sesuaikan logikanya dengan kebutuhan Anda
        $this->db->query("
            SELECT k.komentar as message, k.tanggal, 
                   CASE 
                     WHEN k.komentar LIKE '%ditolak%' THEN 'danger'
                     ELSE 'success' 
                   END AS type,
                   CASE 
                     WHEN k.komentar LIKE '%ditolak%' THEN 'Berkas Ditolak!'
                     ELSE 'Berkas Diterima!' 
                   END AS title
            FROM komentar k
            INNER JOIN tanggungan t ON k.id_tanggungan = t.id_tanggungan
            WHERE t.nim_mhs = :nim
            ORDER BY k.tanggal DESC
        ");
        $this->db->bind(':nim', $nim);
        return $this->db->resultSet();
    }
}
