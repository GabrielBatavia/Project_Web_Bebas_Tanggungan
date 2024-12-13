<?php
session_start();
// $_SESSION['nim'] = '1000001';

// Load semua file yang diperlukan
require_once '../../app/core/Database.php';
require_once '../../app/models/ProfilModel.php';
require_once '../../app/models/NotifikasiModel.php';
require_once '../../app/models/RiwayatPesanModel.php';
require_once '../../app/controllers/ProfilController.php';

// Ambil data dari controller
$controller = new ProfilController();
$data = $controller->index();

// Setelah ini, $data berisi:
// $data['mahasiswaData'], $data['notifikasiData'], $data['riwayatPesanData']

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Meta tags dan judul -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/profil.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Navbar -->
    <div id="navbar-placeholder"></div>

    <!-- Sidebar dan Konten -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div id="sidebar-placeholder"></div>

            <!-- Konten Utama -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <!-- Bagian Profil -->
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Profil</h2>
                </div>
                <div class="row profile-container">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="card profile-card">
                            <div class="card-header">
                                <h5>Data Pribadi</h5>
                            </div>
                            <div class="card-body">
                                <?php $mahasiswa = $data['mahasiswaData']; ?>
                                <div class="row">
                                    <!-- Kartu Info Individu -->
                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <h6>Nama Lengkap</h6>
                                            <p><?= isset($mahasiswa['nama']) ? htmlspecialchars($mahasiswa['nama']) : '-' ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <h6>NIM</h6>
                                            <p><?= isset($mahasiswa['nim']) ? htmlspecialchars($mahasiswa['nim']) : '-' ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <h6>Email</h6>
                                            <p><?= isset($mahasiswa['email']) ? htmlspecialchars($mahasiswa['email']) : '-' ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <h6>No. Telp</h6>
                                            <p><?= isset($mahasiswa['no_telepon']) ? htmlspecialchars($mahasiswa['no_telepon']) : '-' ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <h6>Status</h6>
                                            <p>Mahasiswa</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <h6>Prodi</h6>
                                            <p><?= isset($mahasiswa['program_studi']) ? htmlspecialchars($mahasiswa['program_studi']) : '-' ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bagian Notifikasi -->
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Notifikasi</h2>
                </div>
                <div class="row profile-container">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="card notifications-card">
                            <div class="card-body">
                                <div id="notifications-content">
                                    <?php 
                                    $notifikasiData = $data['notifikasiData'];
                                    if(!empty($notifikasiData)): 
                                        foreach($notifikasiData as $notif): 
                                    ?>
                                        <div class="alert alert-<?= htmlspecialchars($notif['type']) ?>">
                                            <h6><?= htmlspecialchars($notif['title']) ?></h6>
                                            <p><?= htmlspecialchars($notif['message']) ?></p>
                                        </div>
                                    <?php 
                                        endforeach; 
                                    else: 
                                    ?>
                                        <div class="alert alert-secondary">Tidak ada notifikasi.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bagian Pertanyaan (Riwayat Pesan) -->
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Pertanyaan</h2>
                </div>
                <div class="row profile-container">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="card questions-card">
                            <div class="card-body">
                                <div id="questions-content">
                                    <?php 
                                    $riwayatPesanData = $data['riwayatPesanData'];
                                    if(!empty($riwayatPesanData)): 
                                        foreach($riwayatPesanData as $ques): 
                                    ?>
                                        <div class="alert alert-secondary">
                                            <h6><?= htmlspecialchars($ques['title']) ?></h6>
                                            <p><strong><?= date('d/m/Y H:i', strtotime($ques['tanggal'])) ?></strong></p>
                                            <p><?= htmlspecialchars($ques['message']) ?></p>
                                        </div>
                                    <?php 
                                        endforeach; 
                                    else: 
                                    ?>
                                        <div class="alert alert-secondary">Tidak ada riwayat pertanyaan.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap dan jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://rerofya.github.io/resources/sweetalert.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(function () {
            $("#navbar-placeholder").load("navbar.php");
            $("#sidebar-placeholder").load("sidebar.html");
        });
    </script>
</body>
</html>
