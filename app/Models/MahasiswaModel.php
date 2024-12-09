<?php
// app/models/MahasiswaModel.php

require_once __DIR__ . '/../core/Database.php';

class MahasiswaModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Mendapatkan data mahasiswa berdasarkan jabatan
    // Mendapatkan data mahasiswa berdasarkan jabatan
    public function getMahasiswaByJabatan($id_jabatan)
    {
        $this->db->query("
            SELECT m.nim, m.nama, m.no_telepon, t.status, b.deadline,
                   CASE 
                       WHEN b.deadline < CURDATE() THEN 'Tinggi'
                       WHEN b.deadline BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 'Sedang'
                       ELSE 'Ringan'
                   END AS urgensi
            FROM mahasiswa m
            INNER JOIN tanggungan t ON m.nim = t.nim_mhs
            INNER JOIN berkas b ON t.id_berkas = b.id_berkas
            WHERE b.id_jabatan = :id_jabatan
        ");
        $this->db->bind(':id_jabatan', $id_jabatan);
        return $this->db->resultSet();
    }

    public function getMahasiswaByNIM($nim)
    {
        $this->db->query("SELECT * FROM mahasiswa WHERE nim = :nim");
        $this->db->bind(':nim', $nim);
        return $this->db->single();
    }

    /**
     * Mendapatkan semua riwayat pesan berdasarkan id_jabatan
     *
     * @param int $id_jabatan
     * @return array
     */
    public function getMahasiswaWithRiwayatPesan($id_jabatan)
    {
        $this->db->query("
            SELECT 
                rp.id_riwayat_pesan,
                rp.tanggal,
                m.nim AS nim, -- Alias untuk memastikan kunci 'nim' tersedia
                m.nama AS nama_mahasiswa,
                m.no_telepon,
                rp.pesan_mhs,
                rp.pesan_verifikator,
                rp.status,
                CASE 
                    WHEN DATEDIFF(CURDATE(), DATE(rp.tanggal)) >= 7 THEN 'Tinggi'
                    WHEN DATEDIFF(CURDATE(), DATE(rp.tanggal)) >= 3 THEN 'Sedang'
                    ELSE 'Ringan'
                END AS urgensi
            FROM riwayat_pesan rp
            INNER JOIN mahasiswa m ON rp.nim_mhs = m.nim
            WHERE rp.tujuan_id_jabatan = :id_jabatan
            ORDER BY rp.tanggal DESC
        ");
        $this->db->bind(':id_jabatan', $id_jabatan);
        return $this->db->resultSet();
    }

        // Jika Anda ingin mengambil hanya riwayat pesan terbaru per mahasiswa, Anda bisa menggunakan subquery:
        public function getMahasiswaWithLatestRiwayatPesan($id_jabatan)
        {
            $this->db->query("
                SELECT 
                    m.nim, 
                    m.nama, 
                    m.no_telepon, 
                    rp.status,
                    rp.tanggal,
                    CASE 
                        WHEN DATEDIFF(CURDATE(), DATE(rp.tanggal)) >= 7 THEN 'Tinggi'
                        WHEN DATEDIFF(CURDATE(), DATE(rp.tanggal)) >= 3 THEN 'Sedang'
                        ELSE 'Ringan'
                    END AS urgensi
                FROM mahasiswa m
                INNER JOIN (
                    SELECT 
                        rp1.*
                    FROM riwayat_pesan rp1
                    INNER JOIN (
                        SELECT nim_mhs, MAX(tanggal) AS max_tanggal
                        FROM riwayat_pesan
                        WHERE tujuan_id_jabatan = :id_jabatan
                        GROUP BY nim_mhs
                    ) rp2 ON rp1.nim_mhs = rp2.nim_mhs AND rp1.tanggal = rp2.max_tanggal
                ) rp ON m.nim = rp.nim_mhs
                WHERE rp.tujuan_id_jabatan = :id_jabatan
                ORDER BY rp.tanggal DESC
            ");
            $this->db->bind(':id_jabatan', $id_jabatan);
            return $this->db->resultSet();
        }

    /**
     * Mengupdate pesan_verifikator dan status pesan menjadi 'Dibalas'
     *
     * @param int $id_pesan
     * @param string $balasan
     * @param string $status
     * @return bool
     */
    public function updatePesanVerifikator($id_pesan, $balasan, $status)
    {
        $this->db->query("
            UPDATE riwayat_pesan
            SET pesan_verifikator = :balasan,
                status = :status
            WHERE id_riwayat_pesan = :id_pesan
        ");
        $this->db->bind(':balasan', $balasan);
        $this->db->bind(':status', $status);
        $this->db->bind(':id_pesan', $id_pesan);
        return $this->db->execute();
    }

    /**
     * Mengupdate status pesan menjadi 'Terbaca'
     *
     * @param int $id_pesan
     * @param string $status
     * @return bool
     */
    public function updateStatusPesan($id_pesan, $status)
    {
        $this->db->query("
            UPDATE riwayat_pesan
            SET status = :status
            WHERE id_riwayat_pesan = :id_pesan
        ");
        $this->db->bind(':status', $status);
        $this->db->bind(':id_pesan', $id_pesan);
        return $this->db->execute();
    }
}
?>
