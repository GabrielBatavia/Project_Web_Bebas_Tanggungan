<?php
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

// Ambil data tanggungan berdasarkan NIM
$tanggungan = $tanggunganModel->getTanggunganByNIM($nim);

// Ambil data overview
$selesai = $overviewModel->getSelesaiByNIM($nim);
$belumSelesai = $overviewModel->getBelumSelesaiByNIM($nim);
$pending = $overviewModel->getPendingByNIM($nim);
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
                        <div class="timeline-item">
                            <div class="timeline-icon">1</div>
                            <div class="timeline-content">
                                <h5>Pengumpulan Skripsi</h5>
                                <p>Deskripsi aktivitas pertama yang harus dilakukan.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon">2</div>
                            <div class="timeline-content">
                                <h5>Pengumpulan Program</h5>
                                <p>Deskripsi aktivitas kedua yang harus dilakukan.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon">3</div>
                            <div class="timeline-content">
                                <h5>Pengumpulan publikasi</h5>
                                <p>Deskripsi aktivitas ketiga yang harus dilakukan.</p>
                            </div>
                        </div>
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
                                <?php foreach ($tanggungan as $item): ?>
                                    <div class="item-list mb-2">
                                        <span>
                                            <b><?= htmlspecialchars($item['nama_berkas']); ?></b><br>
                                            <small><?= htmlspecialchars($item['deskripsi']); ?></small><br>
                                            <small>Status: <?= htmlspecialchars($item['status']); ?></small><br>
                                            <a href="#" class="btn-detail" data-toggle="modal" data-target="#detailModal" 
                                               data-nama="<?= htmlspecialchars($item['nama_berkas']); ?>" 
                                               data-status="<?= htmlspecialchars($item['status']); ?>" 
                                               data-deskripsi="<?= htmlspecialchars($item['deskripsi']); ?>">Selengkapnya ></a>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
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
                                                <a href="#" class="btn-detail" data-toggle="modal" data-target="#detailModal" 
                                                   data-nama="<?= htmlspecialchars($item['nama_berkas']); ?>" 
                                                   data-status="<?= htmlspecialchars($item['status']); ?>" 
                                                   data-deskripsi="Tidak ada deskripsi.">Selengkapnya ></a>
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

    <!-- pop up -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Berkas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="modal-content">Detail tidak tersedia.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
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

        // Script untuk pop up
        $(document).on('click', '.btn-detail', function () {
            var nama = $(this).data('nama');
            var status = $(this).data('status');
            var deskripsi = $(this).data('deskripsi');

            var content = `
                <strong>Nama Berkas:</strong> ${nama}<br>
                <strong>Status:</strong> ${status}<br>
                <strong>Deskripsi:</strong> ${deskripsi}
            `;
            $('#modal-content').html(content);
        });
    </script>
</body>

</html>
