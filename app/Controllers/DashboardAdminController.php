<?php
// app/controllers/DashboardController.php

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

    public function getDashboardData($id_jabatan)
    {
        // Mendapatkan data statistik
        $data = [];
        $data['total_users'] = $this->userModel->getTotalUsers();
        $data['total_verif_berkas'] = $this->tanggunganModel->getVerifBerkasCount($id_jabatan);
        $data['total_berkas_selesai'] = $this->tanggunganModel->getBerkasSelesaiCount($id_jabatan);
        return $data;
    }

    public function getMahasiswaData($id_jabatan)
    {
        // Mendapatkan data mahasiswa berdasarkan jabatan
        return $this->mahasiswaModel->getMahasiswaByJabatan($id_jabatan);
    }
}
?>
