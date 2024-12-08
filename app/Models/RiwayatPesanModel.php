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

    public function insertPesan($data)
    {
        $sql = "INSERT INTO riwayat_pesan (tujuan_id_jabatan, nim_mhs, pesan_mhs) VALUES (:tujuan_id_jabatan, :nim_mhs, :pesan_mhs)";
        $this->db->query($sql);
        $this->db->bind(':tujuan_id_jabatan', $data['tujuan_id_jabatan']);
        $this->db->bind(':nim_mhs', $data['nim_mhs']);
        $this->db->bind(':pesan_mhs', $data['pesan_mhs']);

        return $this->db->execute();
    }
    
}
