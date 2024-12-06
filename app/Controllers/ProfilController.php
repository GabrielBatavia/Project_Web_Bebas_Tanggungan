<?php
class ProfilController {
    private $profilModel; 
    private $notifikasiModel;
    private $riwayatPesanModel;

    public function __construct() {
        $this->profilModel = new ProfilModel(); 
        $this->notifikasiModel = new NotifikasiModel();
        $this->riwayatPesanModel = new RiwayatPesanModel();
    }

    public function index() {
        // Jangan session_start() di sini jika sudah di public/profil.php
        // Jika ingin tetap di sini, pastikan public/profil.php tidak lagi memanggil session_start()
        // Untuk aman, hapus saja session_start() di sini.
        // session_start();
        
        $nim = $_SESSION['nim'] ?? '1234567890';

        $mahasiswaData = $this->profilModel->getMahasiswaByNIM($nim); 
        $notifikasiData = $this->notifikasiModel->getNotifikasiByNIM($nim);
        $riwayatPesanData = $this->riwayatPesanModel->getRiwayatPesanByNIM($nim);

        // Kembalikan data ke public/profil.php agar dapat ditampilkan di sana
        return [
            'mahasiswaData' => $mahasiswaData,
            'notifikasiData' => $notifikasiData,
            'riwayatPesanData' => $riwayatPesanData
        ];
    }
}
