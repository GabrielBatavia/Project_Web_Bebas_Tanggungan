<?php
class MahasiswaController extends Controller {
    private $mahasiswaModel;

    public function __construct() {
        $this->mahasiswaModel = $this->model('Mahasiswa');
    }

    public function index() {
        $mahasiswa = $this->mahasiswaModel->getMahasiswaById(1);  // ID mahasiswa dummy
        $this->view('dataMahasiswa', $mahasiswa);
    }

    public function update() {
        $data = [
            'student_id' => $_POST['student_id'],
            'name' => $_POST['name'],
            'major' => $_POST['major']
        ];
        $this->mahasiswaModel->updateMahasiswa($data);
        header("Location: /mahasiswa");
    }
}
