<?php
// Data dummy untuk dashboard
$jumlah_mahasiswa = 300;
$jumlah_dosen = 30;
$submit_tugas_akhir = 200;
$belum_submit_tugas_akhir = $jumlah_mahasiswa - $submit_tugas_akhir;
$total_uploads_diperlukan = 500;
$total_uploads_user = 350;

$data_chart = [
    'jumlahMahasiswa' => $jumlah_mahasiswa,
    'jumlahDosen' => $jumlah_dosen,
    'submitTugasAkhir' => $submit_tugas_akhir,
    'belumSubmitTugasAkhir' => $belum_submit_tugas_akhir,
    'totalUploadsUser' => $total_uploads_user,
    'totalUploadsDiperlukan' => $total_uploads_diperlukan
];
?>
