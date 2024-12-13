<?php
// app/controllers/CekVerifyController.php

require_once __DIR__ . '/../core/Controller.php';

class CekVerifyController extends Controller
{
    private $tanggunganModel;
    private $mahasiswaModel;
    private $fileUploadModel;
    private $komentarModel;

    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor parent untuk inisialisasi koneksi
        $this->tanggunganModel = $this->model('TanggunganModel');
        $this->mahasiswaModel = $this->model('MahasiswaModel');
        $this->fileUploadModel = $this->model('FileUploadModel');
        $this->komentarModel = $this->model('KomentarModel');
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
    public function updateStatusAndKomentar($id_verifikator, $data)
    {
        $success = true;
        foreach ($data as $tanggungan) {
            // Update status di tabel tanggungan
            $updateStatus = $this->tanggunganModel->updateStatus($tanggungan['id_tanggungan'], $tanggungan['status']);
            if (!$updateStatus) {
                $success = false;
                break;
            }

            // Tambahkan komentar di tabel komentar jika ada catatan
            if (!empty($tanggungan['komentar'])) {
                $addKomentar = $this->komentarModel->addKomentar($tanggungan['id_tanggungan'], $id_verifikator, $tanggungan['komentar']);
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
