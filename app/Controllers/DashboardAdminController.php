<?php
// app/controllers/DashboardAdminController.php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/TanggunganModel.php';
require_once __DIR__ . '/../models/MahasiswaModel.php';

class DashboardAdminController extends Controller
{
    private $userModel;
    private $tanggunganModel;
    private $mahasiswaModel;

    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
        $this->tanggunganModel = $this->model('TanggunganModel');
        $this->mahasiswaModel = $this->model('MahasiswaModel');
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

    // Fungsi baru untuk mendapatkan riwayat pesan tidak diperlukan lagi karena sudah termasuk dalam getMahasiswaData
}
?>
