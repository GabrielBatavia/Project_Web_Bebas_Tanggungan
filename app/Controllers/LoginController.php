<?php

require_once '../app/core/Controller.php';
require_once '../app/core/Database.php';

class LoginController extends Controller
{
    private $db;

    public function __construct()
    {
        // Instantiate the Database connection
        $this->db = new Database();
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
        $query = "SELECT * FROM mahasiswa WHERE nim = :username AND password = :password";
        $this->db->query($query);
        $this->db->bind(':username', $username);
        $this->db->bind(':password', $password);

        return $this->db->single();
    }

    private function getVerifikator($username, $password)
    {
        $query = "SELECT * FROM verifikator WHERE nip = :username AND password = :password";
        $this->db->query($query);
        $this->db->bind(':username', $username);
        $this->db->bind(':password', $password);

        return $this->db->single();
    }

    private function setSession($user, $role)
    {
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
