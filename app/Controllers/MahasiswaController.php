<?php
class MahasiswaController extends Controller {
    private $mahasiswaModel;

    public function __construct() {
        $this->mahasiswaModel = $this->model('Mahasiswa');
    }

    public function index() {
        // Ambil data dummy
        $mahasiswa = $this->mahasiswaModel->getMahasiswaById(1);  // ID mahasiswa dummy
        // Kirim data dummy ke view
        $this->view('dataMahasiswa', $mahasiswa);
    }

    public function update() {
        $data = [
            'student_id' => $_POST['student_id'],
            'name' => $_POST['name'],
            'major' => $_POST['major']
        ];
        
        // Simulasikan proses update (dummy)
        $this->mahasiswaModel->updateMahasiswa($data);
        
        header("Location: /mahasiswa");
    }
}
