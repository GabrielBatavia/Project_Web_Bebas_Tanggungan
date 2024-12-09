<?php
// public/Admin/pesanAdmin.php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.html");
    exit;
}

require_once __DIR__ . '/../../app/controllers/DashboardAdminController.php';

$dashboardController = new DashboardAdminController();

// Dapatkan instance MahasiswaModel dari DashboardAdminController
$mahasiswaModel = $dashboardController->getMahasiswaModel();

// Mendapatkan id_jabatan dari session
$id_jabatan = $_SESSION['id_jabatan'];

// Mendapatkan ID riwayat_pesan dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id_pesan = $_GET['id'];

// Mendapatkan data pesan berdasarkan id_pesan dan id_jabatan
$mahasiswaData = $dashboardController->getMahasiswaData($id_jabatan);
$pesan = null;
foreach ($mahasiswaData as $p) {
    if ($p['id_riwayat_pesan'] == $id_pesan) {
        $pesan = $p;
        break;
    }
}

if (!$pesan) {
    echo "Pesan tidak ditemukan atau Anda tidak berwenang untuk melihat pesan ini.";
    exit;
}

// Jika status pesan masih 'Menunggu', ubah menjadi 'Terbaca'
if ($pesan['status'] === 'Menunggu') {
    $mahasiswaModel->updateStatusPesan($id_pesan, 'Terbaca');
    // Refresh data pesan setelah update
    $pesan['status'] = 'Terbaca';
}

// Menghandle form submit untuk membalas pesan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $balasan = trim($_POST['balasan']);

    if (!empty($balasan)) {
        // Update pesan_verifikator dan status menjadi 'Dibalas'
        $mahasiswaModel->updatePesanVerifikator($id_pesan, $balasan, 'Dibalas');

        // Redirect kembali ke dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Balasan tidak boleh kosong.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Meta tags dan judul -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Prodi - Detail Pesan</title>
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
    <link rel="stylesheet" href="../css/toast.css">
    <link rel="stylesheet" href="../css/pesanAdmin.css">
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
                <!-- Title dan Breadcrumb -->
                <div class="title">
                    <div class="pt-4 pb-2 mb-3 border-bottom border-dark">
                        <h2>Pesan</h2>
                    </div>
                    <div class="header d-flex justify-content-between align-items-center">
                        <div class="left">
                            <h2>Detail Pesan</h2>
                            <ul class="breadcrumb">
                                <li>
                                    <a href="dashboard.php" class="li1">Dashboard</a>
                                </li>
                                <li><i class="fa-solid fa-chevron-right"></i></li>
                                <li>
                                    <a href="listBerkas.php" class="li2">List Berkas</a>
                                </li>
                                <li><i class="fa-solid fa-chevron-right"></i></li>
                                <li>
                                    <a href="#" class="li3">Pesan</a>
                                </li>
                            </ul>
                        </div>
                        <div class="button">
                            <form method="POST" action="">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Konten Utama -->
                <div class="contentf container">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Box1 (Detail Mahasiswa) -->
                            <div class="card box1 mb-4">
                                <div class="card-desc p-4">
                                    <h4>Detail Mahasiswa</h4>
                                    <div class="bio">
                                        <div class="bio-item">
                                            <span class="label">Nama</span>
                                            <span class="value"><?php echo htmlspecialchars($pesan['nama_mahasiswa']); ?></span>
                                        </div>
                                        <div class="bio-item">
                                            <span class="label">Tanggal</span>
                                            <span class="value"><?php echo htmlspecialchars(date("d M Y", strtotime($pesan['tanggal']))); ?></span>
                                        </div>
                                        <div class="bio-item">
                                            <span class="label">Waktu</span>
                                            <span class="value"><?php echo htmlspecialchars(date("H:i", strtotime($pesan['tanggal']))); ?></span>
                                        </div>
                                        <div class="bio-item">
                                            <span class="label">Label</span>
                                            <span class="value"><?php echo htmlspecialchars($pesan['status']); ?></span>
                                        </div>
                                        <div class="bio-item">
                                            <span class="label">Detail Tujuan</span>
                                            <span class="value"><?php echo htmlspecialchars($pesan['detail_tujuan'] ?? '-'); ?></span>
                                        </div>
                                        <div class="bio-item">
                                            <span class="label">Surat Pendukung</span>
                                            <span class="value">
                                                <?php
                                                if (!empty($pesan['surat_pendukung'])) {
                                                    echo '<a href="../uploads/' . htmlspecialchars($pesan['surat_pendukung']) . '" target="_blank">Lihat Surat</a>';
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Box2 (Aksi) -->
                            <div class="card box2 mb-4">
                                <div class="card-desc p-4">
                                    <h4 class="desc1">Aksi</h4>
                                    <form method="POST" action="">
                                        <?php if (isset($error)): ?>
                                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <label for="balasan">Balas</label>
                                            <textarea name="balasan" class="form-control" placeholder="Masukkan Pesan Balasan" rows="6" required><?php echo isset($_POST['balasan']) ? htmlspecialchars($_POST['balasan']) : ''; ?></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Kirim Balasan</button>
                                        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Box3 (Pesan) -->
                            <div class="card box3 mb-4">
                                <div class="card-desc p-4">
                                    <h4 class="desc1">Pesan</h4>
                                    <div class="form-group">
                                        <label>Pesan Mahasiswa:</label>
                                        <textarea class="form-control" rows="6" readonly><?php echo nl2br(htmlspecialchars($pesan['pesan_mhs'])); ?></textarea>
                                    </div>
                                    <?php if (!empty($pesan['pesan_verifikator'])): ?>
                                        <div class="form-group mt-3">
                                            <label>Pesan Verifikator:</label>
                                            <textarea class="form-control" rows="6" readonly><?php echo nl2br(htmlspecialchars($pesan['pesan_verifikator'])); ?></textarea>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                

                <!-- Toast Container -->
                <div id="toast-container" aria-live="polite" aria-atomic="true" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999;"></div>

                <!-- Bootstrap dan jQuery JS -->
                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
                <!-- Chart.js dan script custom -->
                <script>
                    let documentsSubmitted = 0;
                    $('.file-uploadan').click(function () {
                        documentsSubmitted += 1;
                        console.log("test")
                    });

                    $(function () {
                        $("#navbar-placeholder").load("navbar.html");
                        $("#sidebar-placeholder").load("sidebar.html");
                        $('#cetak').click(function () {
                            if (!documentsSubmitted) {
                                showToast("Anda belum mengumpulkan semua berkas. Silakan lengkapi berkas terlebih dahulu.", "danger");
                            } else {
                                window.location.href = "../img/Surat-Bebas-Tanggungan.png";
                                showToast("File telah diunduh", "success");
                            }
                        });
                    });

                    // Show Toast
                    function showToast(message, type = 'light') {
                        const toastHTML = `
                    <div class="toast align-items-center text-white bg-${type} mt-2" role="alert" aria-live="assertive" aria-atomic="true">
                        <div>
                            <div class="toast-header">
                                <strong class="mr-auto">Sistem Bebas Tanggungan</strong>
                                <button type="button" class="ml-2 mb-1 close" data-bs-dismiss="toast" aria-label="Close">&times;</button>
                            </div>
                            <div class="toast-body">
                                ${message}
                            </div>
                        </div>
                    </div>`;

                        const toastContainer = $('#toast-container');
                        toastContainer.append(toastHTML);
                        const toast = new bootstrap.Toast(toastContainer.find('.toast').last()[0]);
                        toast.show();

                        toastContainer.find('.toast').on('hidden.bs.toast', function () {
                            $(this).remove();
                        });
                    }
                </script>
            </main>
        </div>
    </div>
</body>

</html>
