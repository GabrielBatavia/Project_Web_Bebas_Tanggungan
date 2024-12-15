<?php
// public/Admin/sub-menu.php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.html");
    exit;
}

require_once __DIR__ . '/../../app/controllers/DashboardAdminController.php';

$dashboardController = new DashboardAdminController();

// Mendapatkan id_jabatan dari session
$id_jabatan = $_SESSION['id_jabatan'];

// Mendapatkan status dari GET parameter, default 'all' jika tidak ada
$status = isset($_GET['status']) ? $_GET['status'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Mendapatkan data dashboard
$dashboardData = $dashboardController->getDashboardData($id_jabatan);

// Mendapatkan data mahasiswa berdasarkan status dan search
if ($status === 'all') {
    $mahasiswaData = $dashboardController->getMahasiswaData($id_jabatan);
} else {
    $mahasiswaData = $dashboardController->getMahasiswaDataByStatus($id_jabatan, $status);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags dan judul -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <!-- CSS khusus untuk dashboard admin -->
    <link rel="stylesheet" href="../css/admin-dashboard.css">
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
                <!-- Header Dashboard -->
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Dashboard Verifikator</h2>
                </div>

                <!-- Statistik Card -->
                <div class="row stats-row">
                    <div class="col-md-4 mb-4">
                        <div class="card admin-card pengguna-card">
                            <div class="card-body">
                                <h5>Pengguna</h5>
                                <h3 class="stat-number"><?php echo htmlspecialchars($dashboardData['total_users']); ?></h3>
                                <p>Total pengguna keseluruhan</p>
                            </div>
                            <i class="fas fa-users card-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card admin-card verif-berkas-card">
                            <div class="card-body">
                                <h5>Mahasiswa Verif Berkas</h5>
                                <h3 class="stat-number"><?php echo htmlspecialchars($dashboardData['total_verif_berkas']); ?></h3>
                                <p>Total pengguna persyaratan lengkap</p>
                            </div>
                            <i class="fas fa-file-alt card-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card admin-card berkas-selesai-card">
                            <div class="card-body">
                                <h5>Mahasiswa Berkas Selesai</h5>
                                <h3 class="stat-number"><?php echo htmlspecialchars($dashboardData['total_berkas_selesai']); ?></h3>
                                <p>Total pengguna berkas lengkap</p>
                            </div>
                            <i class="fas fa-check-circle card-icon"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Filter dan Search -->
                <div class="d-flex filter-search">
                    <div class="filter-container mr-3">
                        <div class="btn-group toggle-btn-group">
                            <a href="sub-menu.php?status=all" class="btn btn-outline-primary <?php echo ($status === 'all') ? 'active' : ''; ?>">Semua</a>
                            <a href="sub-menu.php?status=belum" class="btn btn-outline-primary <?php echo ($status === 'belum') ? 'active' : ''; ?>">Belum Terverifikasi</a>
                            <a href="sub-menu.php?status=sebagian" class="btn btn-outline-primary <?php echo ($status === 'sebagian') ? 'active' : ''; ?>">Verifikasi Sebagian</a>
                            <a href="sub-menu.php?status=terverifikasi" class="btn btn-outline-primary <?php echo ($status === 'terverifikasi') ? 'active' : ''; ?>">Terverifikasi</a>
                        </div>
                    </div>
                    <div class="input-group search-group">
                        <form method="GET" action="sub-menu.php">
                            <input type="hidden" name="status" value="<?php echo htmlspecialchars($status); ?>">
                            <input type="text" name="search" class="form-control" placeholder="Search" value="<?php echo htmlspecialchars($search); ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table class="table admin-table">
                        <thead>
                            <tr>
                                <th>No. Induk</th>
                                <th>Nama Lengkap</th>
                                <th>No. Telepon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($mahasiswaData)): ?>
                                <?php foreach ($mahasiswaData as $mhs): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($mhs['nim']); ?></td>
                                    <td><?php echo isset($mhs['nama']) ? htmlspecialchars($mhs['nama']) : htmlspecialchars($mhs['nama_mahasiswa']); ?></td>
                                    <td><?php echo htmlspecialchars($mhs['no_telepon']); ?></td>
                                    <td>
                                        <?php
                                        // Menampilkan status dengan badge
                                        if ($status === 'belum') {
                                            echo '<span class="badge badge-danger">Belum Terverifikasi</span>';
                                        } elseif ($status === 'sebagian') {
                                            echo '<span class="badge badge-warning">Verifikasi Sebagian</span>';
                                        } elseif ($status === 'terverifikasi') {
                                            echo '<span class="badge badge-success">Terverifikasi</span>';
                                        } else {
                                            // Status default jika 'all', bisa disesuaikan
                                            echo '<span class="badge badge-secondary">All</span>';
                                        }
                                        ?>
                                    </td>
                                    <td><a href="cekVerify.php" class="btn-detail"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center pagination-container">
                    <p>Menampilkan <?php echo count($mahasiswaData); ?> data dari total</p>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">&laquo;</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <!-- Tambahkan halaman lain sesuai kebutuhan -->
                            <li class="page-item">
                                <a class="page-link" href="#">&raquo;</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap dan jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js dan script custom -->
    <script>
        // Memasukkan navbar dan sidebar
        $(function(){
            $("#navbar-placeholder").load("navbar.php");
            $("#sidebar-placeholder").load("sidebar.html");
        });

        // Script untuk Toggle Active pada Button Group
        $(document).ready(function(){
            $('.toggle-btn-group .btn').on('click', function(){
                $('.toggle-btn-group .btn').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
</body>
</html>
