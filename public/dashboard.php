<?php
// Include Overview.php dan Tanggungan.php
require_once "../config/Database.php";
require_once "../app/models/Tanggungan.php";
require_once "../app/models/Overview.php";

// Inisialisasi koneksi database
$database = new Database();
$db = $database->connect();

// Cek koneksi dan ambil data dari Overview.php dan Tanggungan.php
if ($db) {
    $overview = new Overview($db);
    $tanggunganModel = new Tanggungan($db);

    $selesai = $overview->getSelesai();
    $belumSelesai = $overview->getBelumSelesai();
    $pending = $overview->getPending();

    $tanggungan = $tanggunganModel->getBelumSelesaiTanggungan()->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Jika koneksi gagal, gunakan data statis untuk debug
    $selesai = [
        ["id_tanggungan" => 1, "nama_berkas" => "Formulir Pendaftaran", "status" => "Selesai"],
    ];
    $belumSelesai = [
        ["id_tanggungan" => 2, "nama_berkas" => "Proposal Penelitian", "status" => "Belum Selesai"],
    ];
    $pending = [
        ["id_tanggungan" => 3, "nama_berkas" => "Surat Keterangan", "status" => "Pending"],
    ];

    $tanggungan = [
        ["nama_berkas" => "Tanda Terima Penyerahan Laporan TA", "deskripsi" => "Upload laporan TA", "status" => "Terlambat"],
        ["nama_berkas" => "Tanda Terima Penyerahan Laporan PKL", "deskripsi" => "Upload laporan PKL", "status" => "Overdue by 2 days"],
    ];
}
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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/sidebar.css">
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
                        <div class="timeline-item">
                            <div class="timeline-icon">4</div>
                            <div class="timeline-content">
                                <h5>Penyelesaian</h5>
                                <p>Deskripsi aktivitas terakhir yang harus diselesaikan.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon">5</div>
                            <div class="timeline-content">
                                <h5>Penyelesaian</h5>
                                <p>Deskripsi aktivitas terakhir yang harus diselesaikan.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon">6</div>
                            <div class="timeline-content">
                                <h5>Penyelesaian</h5>
                                <p>Deskripsi aktivitas terakhir yang harus diselesaikan.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon">6</div>
                            <div class="timeline-content">
                                <h5>Penyelesaian</h5>
                                <p>Deskripsi aktivitas terakhir yang harus diselesaikan.</p>
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
                                            <small>Status: <?= htmlspecialchars($item['status']); ?></small>
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
                <div class="footer" id="footer"></div>
            </main>
        </div>
    </div>

    <!-- Bootstrap dan jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Include navbar dan sidebar
        $(function () {
            $("#navbar-placeholder").load("navbar.html");
            $("#sidebar-placeholder").load("sidebar.html");
            $("#footer").load("footer.html");
        });
    </script>
</body>

</html>
