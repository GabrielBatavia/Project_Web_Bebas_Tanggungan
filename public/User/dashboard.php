<?php
// public/User/dashboard.php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.html");
    exit;
}

// Include Database dan Models
require_once "../../app/core/Database.php";
require_once "../../app/models/Tanggungan.php";
require_once "../../app/models/Overview.php";

// Inisialisasi Database
$db = new Database();

// Inisialisasi Models dengan koneksi database
$tanggunganModel = new Tanggungan($db->dbh);
$overviewModel = new Overview($db->dbh);

// Ambil NIM dari session
$nim = $_SESSION['nim'];

// Ambil data tanggungan berdasarkan NIM dengan filter dan limit
$tanggungan = $tanggunganModel->getFilteredTanggunganByNIM($nim, 7);

// Ambil data overview
$selesai = $overviewModel->getSelesaiByNIM($nim);
$belumSelesai = $overviewModel->getBelumSelesaiByNIM($nim);
$pending = $overviewModel->getPendingByNIM($nim);

$selesaiNames = array_column($selesai, 'nama_berkas');
$pendingNames = array_column($pending, 'nama_berkas');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags dan judul -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Import Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/sidebar.css">
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
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Beranda</h2>
                </div>

                <!-- Timeline -->
                <div class="timeline-container">
                    <h2 class="timeline-title">Timeline Pengumpulan</h2>
                    <div class="timeline">
                        <?php
                        // Daftar langkah dalam timeline
                        $timelineSteps = [
                            1 => 'Pengumpulan Skripsi',
                            2 => 'Pengumpulan Program',
                            3 => 'Pengumpulan Publikasi',
                            4 => 'Distribusi Buku Skripsi',
                            5 => 'Distribusi Laporan PKL',
                            6 => 'Bebas Kompen',
                            7 => 'Upload Scan TOEIC'
                        ];

                        foreach ($timelineSteps as $stepNumber => $stepName) {
                            // Tentukan apakah langkah ini sudah selesai atau pending
                            $isCompleted = in_array($stepName, $selesaiNames) || in_array($stepName, $pendingNames);
                            
                            // Tentukan kelas untuk ikon berdasarkan status
                            $iconClass = 'timeline-icon';
                            if ($isCompleted) {
                                $iconClass .= ' completed';
                            }

                            echo '<div class="timeline-item">';
                            echo '<div class="' . $iconClass . '">' . $stepNumber . '</div>';
                            echo '<div class="timeline-content">';
                            echo '<h5>' . htmlspecialchars($stepName) . '</h5>';
                            echo '<p>Deskripsi aktivitas ' . strtolower($stepName) . ' yang harus dilakukan.</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Dua Visualisasi: List Tanggungan dan Overview -->
                <div class="row mt-4">
                    <!-- List Tanggungan -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-verydarkblue text-white">
                                List Tanggungan
                            </div>
                            <div class="card-body">
                                <?php if (!empty($tanggungan)): ?>
                                    <?php foreach ($tanggungan as $item): ?>
                                        <div class="item-list mb-2">
                                            <span>
                                                <b><?= htmlspecialchars($item['nama_berkas']); ?></b><br>
                                                <small><?= htmlspecialchars($item['deskripsi']); ?></small><br>
                                                <small>Status: <?= htmlspecialchars($item['status']); ?></small>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Tidak ada tanggungan yang berstatus Pending atau Ditolak.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>


                    <!-- Overview -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-verydarkblue text-white">
                                Overview
                            </div>
                            <div class="card-body">
                                <!-- Overview Item ACC -->
                                <div class="acc mb-3">
                                    <div class="row px-3 py-1 text-verygreen" style="border-radius: 10px;">
                                        <span><i class="fas fa-check mr-2"></i>Diterima</span>
                                    </div>
                                    <?php foreach ($selesai as $item): ?>
                                        <div class="item-list">
                                            <span>
                                                <?= htmlspecialchars($item['nama_berkas']); ?><br>
                                                <small>Status: <?= htmlspecialchars($item['status']); ?></small><br>
                                                <a href="#" class="btn-detail">Selengkapnya ></a>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Overview Item REJECT -->
                                <div class="reject mb-3">
                                    <div class="row px-3 py-1 text-red" style="border-radius: 10px;">
                                        <span><i class="fas fa-xmark mr-2"></i>Ditolak</span>
                                    </div>
                                    <?php foreach ($belumSelesai as $item): ?>
                                        <div class="item-list">
                                            <span>
                                                <?= htmlspecialchars($item['nama_berkas']); ?><br>
                                                <small>Status: <?= htmlspecialchars($item['status']); ?></small><br>
                                                <a href="#" class="btn-detail">Selengkapnya ></a>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Overview Item PENDING -->
                                <div class="pending">
                                    <div class="row px-3 py-1 bg-secondary text-white" style="border-radius: 10px;">
                                        <span><i class="fa-regular fa-clock mr-2"></i>Pending</span>
                                    </div>
                                    <?php foreach ($pending as $item): ?>
                                        <div class="item-list">
                                            <span>
                                                <?= htmlspecialchars($item['nama_berkas']); ?><br>
                                                <small>Status: <?= htmlspecialchars($item['status']); ?></small><br>
                                                <a href="#" class="btn-detail">Detail ></a>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php include 'footer.php';?>
    
    <!-- Bootstrap dan jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Include navbar dan sidebar
        $(function () {
            $("#navbar-placeholder").load("navbar.php");
            $("#sidebar-placeholder").load("sidebar.html");
        });
    </script>
</body>

</html>