<?php
// app/controllers/CekVerifyController.php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/TanggunganModel.php';
require_once __DIR__ . '/../models/MahasiswaModel.php';
// require_once __DIR__ . '/../models/FileUploadModel.php';
require_once __DIR__ . '/../models/KomentarModel.php';

class CekVerifyController extends Controller
{
    private $tanggunganModel;
    private $mahasiswaModel;
    private $fileUploadModel;

    public function __construct()
    {
        $this->tanggunganModel = $this->model('TanggunganModel');
        $this->mahasiswaModel = $this->model('MahasiswaModel');
        $this->fileUploadModel = $this->model('FileUploadModel');
    }

    // Mendapatkan data mahasiswa berdasarkan NIM
    public function getMahasiswaByNIM($nim)
    {
        return $this->mahasiswaModel->getMahasiswaByNIM($nim);
    }

    // Mendapatkan berkas yang dikirimkan oleh mahasiswa ke verifikator tertentu
    public function getFilesByNIMAndJabatan($nim, $id_jabatan)
    {
        return $this->tanggunganModel->getFilesByNIMAndJabatan($nim, $id_jabatan);
    }

    // Mengupdate status verifikasi berkas dan menambahkan komentar
    public function updateStatusAndKomentar($data)
    {
        $success = true;
        foreach ($data['tanggungan'] as $tanggungan) {
            // Update status di tabel tanggungan
            $updateStatus = $this->tanggunganModel->updateStatus($tanggungan['id_tanggungan'], $tanggungan['status']);
            if (!$updateStatus) {
                $success = false;
                break;
            }

            // Tambahkan komentar di tabel komentar jika ada catatan
            if (!empty($tanggungan['komentar'])) {
                $addKomentar = $this->komentarModel->addKomentar($tanggungan['id_tanggungan'], $data['id_verifikator'], $tanggungan['komentar']);
                if (!$addKomentar) {
                    $success = false;
                    break;
                }
            }
        }
        return $success;
    }
}
?>
