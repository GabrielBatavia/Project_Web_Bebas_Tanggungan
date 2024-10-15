<?php
class Mahasiswa {
    // Fungsi untuk mendapatkan data mahasiswa berdasarkan ID
    public function getMahasiswaById($id) {
        // Data dummy yang seakan-akan diambil dari database
        $dummyData = [
            'id' => $id,
            'name' => 'Gabriel Batavia Xaverius',
            'major' => 'Teknik Informatika'
        ];

        return $dummyData; // Kembalikan data dummy
    }

    // Fungsi update data mahasiswa (dummy)
    public function updateMahasiswa($data) {
        // Simulasikan bahwa data berhasil diupdate
        return true;
    }
}
