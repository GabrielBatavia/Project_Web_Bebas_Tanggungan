<?php
require_once "../app/core/Controller.php";

class DashboardController extends Controller {
    private $tanggungan;
    private $overview; 

    public function __construct($db) {
        session_start(); 

        // Cek apakah user sudah login
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            // Jika belum login, redirect ke halaman login
            header("Location: ../public/User/index.php");
            exit;
        }

        // Load model Tanggungan
        $this->tanggungan = $this->model('Tanggungan');

        // Load model Overview jika diperlukan
        $this->overview = $this->model('Overview');
    }

    public function index() {
        $nim = $_SESSION['nim']; // Ambil NIM dari session

        // Ambil data tanggungan berdasarkan NIM
        $tanggunganData = $this->tanggungan->getTanggunganByNIM($nim);

        // Ambil data overview jika diperlukan
        $overviewData = $this->overview->getOverviewByNIM($nim); 

        // Render view dengan data yang relevan
        $this->view("dashboard/index", [
            'tanggungan' => $tanggunganData,
            'overview' => $overviewData, // Opsional
            'nim' => $nim
        ]);
    }
}
?>
