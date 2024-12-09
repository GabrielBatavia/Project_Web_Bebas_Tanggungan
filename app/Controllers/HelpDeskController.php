<?php
// app/controllers/HelpDeskController.php

require_once __DIR__ . '/../core/Controller.php';

class HelpDeskController extends Controller
{
    private $riwayatPesanModel;

    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor parent untuk inisialisasi koneksi
        $this->riwayatPesanModel = $this->model('RiwayatPesanModel');
    }

    public function sendMessage()
    {
        // Pastikan pengguna sudah login
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: ../index.html");
            exit;
        }

        // Validasi input
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pesan_mhs = trim($_POST['pesan_mhs']);
            $tujuan_id_jabatan = intval($_POST['tujuan_id_jabatan']);
            $nim_mhs = $_SESSION['nim'];

            // Cek apakah pesan tidak kosong dan tujuan_id_jabatan valid
            if (!empty($pesan_mhs) && in_array($tujuan_id_jabatan, [1, 2])) {
                // Siapkan data untuk disimpan
                $data = [
                    'tujuan_id_jabatan' => $tujuan_id_jabatan,
                    'nim_mhs' => $nim_mhs,
                    'pesan_mhs' => $pesan_mhs
                ];

                // Panggil model untuk menyimpan data
                if ($this->riwayatPesanModel->insertPesan($data)) {
                    // Redirect kembali ke helpDesk dengan parameter sukses
                    header("Location: helpDesk.php?status=success");
                    exit;
                } else {
                    // Redirect dengan parameter error
                    header("Location: helpDesk.php?status=error");
                    exit;
                }
            } else {
                // Redirect dengan parameter error validasi
                header("Location: helpDesk.php?status=validation_error");
                exit;
            }
        }
    }
}
?>
