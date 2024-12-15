<?php
// app/models/MahasiswaModel.php

class MahasiswaModel
{
    private $db;

    /**
     * Konstruktor menerima instance PDO dari Controller
     *
     * @param PDO $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Mendapatkan data mahasiswa berdasarkan jabatan
    public function getMahasiswaByJabatan($id_jabatan)
    {
        $sql = "
            SELECT m.nim, m.nama, m.no_telepon, t.status, b.deadline,
                   CASE 
                       WHEN b.deadline < GETDATE() THEN 'Tinggi'
                       WHEN b.deadline BETWEEN GETDATE() AND DATEADD(DAY, 7, GETDATE()) THEN 'Sedang'
                       ELSE 'Ringan'
                   END AS urgensi
            FROM mahasiswa m
            INNER JOIN tanggungan t ON m.nim = t.nim_mhs
            INNER JOIN berkas b ON t.id_berkas = b.id_berkas
            WHERE b.id_jabatan = :id_jabatan
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_jabatan', $id_jabatan);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mendapatkan data mahasiswa berdasarkan NIM
    public function getMahasiswaByNIM($nim)
    {
        $sql = "SELECT * FROM mahasiswa WHERE nim = :nim";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nim', $nim);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Mendapatkan semua riwayat pesan berdasarkan id_jabatan
     *
     * @param int $id_jabatan
     * @return array
     */
    public function getMahasiswaWithRiwayatPesan($id_jabatan)
    {
        $sql = "
            SELECT 
                rp.id_riwayat_pesan,
                rp.tanggal,
                m.nim AS nim, 
                m.nama AS nama_mahasiswa,
                m.no_telepon,
                rp.pesan_mhs,
                rp.pesan_verifikator,
                rp.status,
                CASE 
                    WHEN DATEDIFF(DAY, rp.tanggal, GETDATE()) >= 7 THEN 'Tinggi'
                    WHEN DATEDIFF(DAY, rp.tanggal, GETDATE()) >= 3 THEN 'Sedang'
                    ELSE 'Ringan'
                END AS urgensi
            FROM riwayat_pesan rp
            INNER JOIN mahasiswa m ON rp.nim_mhs = m.nim
            WHERE rp.tujuan_id_jabatan = :id_jabatan
            ORDER BY rp.tanggal DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_jabatan', $id_jabatan);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        $sql = "
            UPDATE riwayat_pesan
            SET pesan_verifikator = :balasan,
                status = :status
            WHERE id_riwayat_pesan = :id_pesan
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':balasan', $balasan);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id_pesan', $id_pesan);
        return $stmt->execute();
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
        $sql = "
            UPDATE riwayat_pesan
            SET status = :status
            WHERE id_riwayat_pesan = :id_pesan
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id_pesan', $id_pesan);
        return $stmt->execute();
    }

    // Mendapatkan riwayat pesan terbaru per mahasiswa
    public function getMahasiswaWithLatestRiwayatPesan($id_jabatan)
    {
        $sql = "
            SELECT 
                m.nim, 
                m.nama, 
                m.no_telepon, 
                rp.status,
                rp.tanggal,
                CASE 
                    WHEN DATEDIFF(DAY, rp.tanggal, GETDATE()) >= 7 THEN 'Tinggi'
                    WHEN DATEDIFF(DAY, rp.tanggal, GETDATE()) >= 3 THEN 'Sedang'
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
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_jabatan', $id_jabatan);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        /**
     * Fungsi baru untuk mendapatkan data mahasiswa berdasarkan status
     *
     * @param int $id_jabatan
     * @param string $status
     * @return array
     */
    public function getMahasiswaDataByStatus($id_jabatan, $status)
    {
        if ($status === 'pending') {
            // Belum Terverifikasi: Semua berkas belum disetujui atau ditolak
            $sql = "SELECT DISTINCT m.nim, m.nama, m.no_telepon
                    FROM mahasiswa m
                    JOIN tanggungan t ON m.nim = t.nim_mhs
                    JOIN berkas b ON t.id_berkas = b.id_berkas
                    WHERE b.id_jabatan = :id_jabatan AND t.status = 'Belum Terverifikasi'";
        } elseif ($status === 'Ditolak') {
            // Verifikasi Sebagian: Ada berkas yang sudah disetujui dan ada yang belum atau ditolak
            $sql = "SELECT m.nim, m.nama, m.no_telepon
                    FROM mahasiswa m
                    JOIN tanggungan t ON m.nim = t.nim_mhs
                    JOIN berkas b ON t.id_berkas = b.id_berkas
                    WHERE b.id_jabatan = :id_jabatan
                    GROUP BY m.nim, m.nama, m.no_telepon
                    HAVING SUM(CASE WHEN t.status = 'Terverifikasi' THEN 1 ELSE 0 END) > 0
                       AND SUM(CASE WHEN t.status != 'Terverifikasi' THEN 1 ELSE 0 END) > 0";
        } elseif ($status === 'selesai') {
            // Terverifikasi: Semua berkas sudah disetujui
            $sql = "SELECT DISTINCT m.nim, m.nama, m.no_telepon
                    FROM mahasiswa m
                    JOIN tanggungan t ON m.nim = t.nim_mhs
                    JOIN berkas b ON t.id_berkas = b.id_berkas
                    WHERE b.id_jabatan = :id_jabatan AND t.status = 'Terverifikasi'";
        } else {
            // Default: Semua data tanpa filter status
            $sql = "SELECT DISTINCT m.nim, m.nama, m.no_telepon
                    FROM mahasiswa m
                    JOIN tanggungan t ON m.nim = t.nim_mhs
                    JOIN berkas b ON t.id_berkas = b.id_berkas
                    WHERE b.id_jabatan = :id_jabatan";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_jabatan', $id_jabatan, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
?>
