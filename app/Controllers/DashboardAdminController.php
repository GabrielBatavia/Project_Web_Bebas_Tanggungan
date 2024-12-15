<?php
// app/controllers/DashboardAdminController.php

require_once __DIR__ . '/../core/Controller.php';

class DashboardAdminController extends Controller
{
    private $userModel;
    private $tanggunganModel;
    private $mahasiswaModel;

    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor parent untuk inisialisasi koneksi
        $this->userModel = $this->model('UserModel');
        $this->tanggunganModel = $this->model('TanggunganModel');
        $this->mahasiswaModel = $this->model('MahasiswaModel');
    }

    /**
     * Mendapatkan instance MahasiswaModel
     *
     * @return MahasiswaModel
     */
    public function getMahasiswaModel()
    {
        return $this->mahasiswaModel;
    }

    /**
     * Mendapatkan data statistik dashboard
     *
     * @param int $id_jabatan
     * @return array
     */
    public function getDashboardData($id_jabatan)
    {
        $data = [];
        $data['total_users'] = $this->userModel->getTotalUsers();
        $data['total_verif_berkas'] = $this->tanggunganModel->getVerifBerkasCount($id_jabatan);
        $data['total_berkas_selesai'] = $this->tanggunganModel->getBerkasSelesaiCount($id_jabatan);
        return $data;
    }

    /**
     * Mendapatkan semua riwayat pesan mahasiswa berdasarkan jabatan
     *
     * @param int $id_jabatan
     * @return array
     */
    public function getMahasiswaData($id_jabatan)
    {
        return $this->mahasiswaModel->getMahasiswaWithRiwayatPesan($id_jabatan);
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
        return $this->mahasiswaModel->getMahasiswaDataByStatus($id_jabatan, $status);
    }

    // Fungsi baru lainnya dapat ditambahkan di sini jika diperlukan
}
?>
