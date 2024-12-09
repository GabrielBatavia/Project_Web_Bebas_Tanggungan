<?php
// app/controllers/LoginController.php

require_once __DIR__ . '/../core/Controller.php';

class LoginController extends Controller
{
    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor parent untuk inisialisasi koneksi
    }

    public function authenticate($username, $password)
    {
        $mahasiswa = $this->getMahasiswa($username, $password);

        if ($mahasiswa) {
            $this->setSession($mahasiswa, 'mahasiswa');
            header("Location: User/dashboard.php");
            exit;
        }

        $verifikator = $this->getVerifikator($username, $password);

        if ($verifikator) {
            $this->setSession($verifikator, 'verifikator');
            header("Location: Admin/dashboard.php");
            exit;
        }

        echo "<script>alert('Username atau password salah!'); window.location.href='index.html';</script>";
    }

    private function getMahasiswa($username, $password)
    {
        $query = "SELECT * FROM mahasiswa WHERE nim = :nim AND [password] = :password";
        $this->db->query($query);
        $this->db->bind(':nim', $username);
        $this->db->bind(':password', $password);

        return $this->db->single();
    }

    private function getVerifikator($username, $password)
    {
        $query = "SELECT * FROM verifikator WHERE nip = :nip AND [password] = :password";
        $this->db->query($query);
        $this->db->bind(':nip', $username);
        $this->db->bind(':password', $password);

        return $this->db->single();
    }

    private function setSession($user, $role)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Pastikan sesi dimulai
        }
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['nama'];

        if ($role === 'mahasiswa') {
            $_SESSION['nim'] = $user['nim'];
        } elseif ($role === 'verifikator') {
            $_SESSION['nip'] = $user['nip'];
            $_SESSION['id_jabatan'] = $user['id_jabatan'];
        }

        $_SESSION['role'] = $role;
    }
}
?>
