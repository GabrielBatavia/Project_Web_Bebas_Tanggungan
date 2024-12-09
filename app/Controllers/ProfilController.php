<?php
// app/controllers/ProfilController.php

require_once __DIR__ . '/../core/Controller.php';

class ProfilController extends Controller
{
    private $profilModel; 
    private $notifikasiModel;
    private $riwayatPesanModel;

    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor parent untuk inisialisasi koneksi
        $this->profilModel = $this->model('ProfilModel'); 
        $this->notifikasiModel = $this->model('NotifikasiModel');
        $this->riwayatPesanModel = $this->model('RiwayatPesanModel');
    }

    public function index()
    {
        // Pastikan session sudah dimulai di tempat lain, seperti di public/profil.php
        $nim = $_SESSION['nim'] ?? '1234567890';

        $mahasiswaData = $this->profilModel->getMahasiswaByNIM($nim); 
        $notifikasiData = $this->notifikasiModel->getNotifikasiByNIM($nim);
        $riwayatPesanData = $this->riwayatPesanModel->getRiwayatPesanByNIM($nim);

        // Kembalikan data ke view agar dapat ditampilkan di sana
        return [
            'mahasiswaData' => $mahasiswaData,
            'notifikasiData' => $notifikasiData,
            'riwayatPesanData' => $riwayatPesanData
        ];
    }
}
?>
