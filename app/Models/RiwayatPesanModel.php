<?php
class RiwayatPesanModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getRiwayatPesanByNIM($nim) {
        $this->db->query("SELECT tanggal, pesan_mhs as message, 
                          'Pertanyaan Anda' as title 
                          FROM riwayat_pesan 
                          WHERE nim_mhs = :nim 
                          ORDER BY tanggal DESC");
        $this->db->bind(':nim', $nim);
        return $this->db->resultSet();
    }
}
