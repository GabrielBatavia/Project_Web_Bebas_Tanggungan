<?php
class Controller {
    // Fungsi untuk memanggil model
    public function model($model) {
        require_once '../app/Models/' . $model . '.php';
        $db = new Database(); // Buat instance dari Database
        return new $model($db->connect()); // Panggil metode connect() dari instance
    }
    
    // Fungsi untuk menampilkan view
    public function view($view, $data = []) {
        if (file_exists('../app/Views/' . $view . '.php')) {
            include '../app/Views/' . $view . '.php';
        } else {
            die("View {$view} tidak ditemukan");
        }
    }
}
