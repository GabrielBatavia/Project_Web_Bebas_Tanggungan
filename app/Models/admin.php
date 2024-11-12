<?php
class Admin {
    private $username;
    private $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function ubahStatusBebas($mahasiswa, $status) {
        $mahasiswa->status_bebas = $status;
    }

    public function getMahasiswaById($id) {
        // Logic mengambil data mahasiswa berdasarkan ID dari database
    }
}
?>
