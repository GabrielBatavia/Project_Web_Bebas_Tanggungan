<?php

require_once '../core/Database.php'; // Menggunakan file Database untuk koneksi
require_once '../models/pengumpulan.php'; // Model pengumpulan
require_once '../core/Crud.php'; // Lokasi baru Crud.php dengan namespace Core

use Core\Crud; // Memastikan namespace Crud dipanggil

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $crud = new Crud((new Database())->connect()); // Inisialisasi Crud dengan koneksi database

    $id_tanggungan = $_POST['id_tanggungan'];
    $nama_file = $_FILES['file_upload']['name'];
    $tipe_file = $_FILES['file_upload']['type'];
    $ukuran_file = $_FILES['file_upload']['size'];
    $file_tmp = $_FILES['file_upload']['tmp_name'];

    if ($ukuran_file <= 10485760) { // 10 MB max size
        $file_upload = file_get_contents($file_tmp); // Membaca file untuk disimpan di database

        try {
            // Data yang akan disimpan di tabel `fileupload`
            $data = [
                'id_tanggungan' => $id_tanggungan,
                'nama_file' => $nama_file,
                'tipe_file' => $tipe_file,
                'ukuran_file' => $ukuran_file,
                'file_upload' => $file_upload,
            ];

            // Menjalankan operasi create (insert data) dengan Crud
            if ($crud->create('fileupload', $data)) {
                // Update status pada tabel `tanggungan` menjadi 'Selesai'
                $crud->update('tanggungan', ['status' => 'Selesai'], ['id_tanggungan' => $id_tanggungan]);

                // Redirect jika sukses
                header('Location: ../public/pengumpulanJurusan.php?success=1');
            } else {
                // Redirect jika gagal
                header('Location: ../public/pengumpulanJurusan.php?error=1');
            }
        } catch (Exception $e) {
            // Menampilkan error jika terjadi exception
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Redirect jika file melebihi batas ukuran
        header('Location: ../public/pengumpulanJurusan.php?error=size');
    }
}
?>
