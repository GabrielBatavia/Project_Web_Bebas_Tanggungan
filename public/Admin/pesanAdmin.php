<?php
// public/Admin/pesanAdmin.php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.html");
    exit;
}

require_once __DIR__ . '/../../app/controllers/DashboardAdminController.php';
require_once __DIR__ . '/../../app/models/MahasiswaModel.php';

$dashboardController = new DashboardAdminController();
$mahasiswaModel = new MahasiswaModel();

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
<html lang="en">
<head>
    <!-- Meta tags dan judul -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesan</title>
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
                <!-- Header Halaman -->
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Detail Pesan</h2>
                </div>

                <!-- Detail Pesan -->
                <div class="card mb-4">
                    <div class="card-body">
                        <p><strong>ID Pesan:</strong> <?php echo htmlspecialchars($pesan['id_riwayat_pesan']); ?></p>
                        <p><strong>Tanggal:</strong> <?php echo htmlspecialchars($pesan['tanggal']); ?></p>
                        <p><strong>NIM Mahasiswa:</strong> <?php echo htmlspecialchars($pesan['nim']); ?></p>
                        <p><strong>Nama Mahasiswa:</strong> <?php echo htmlspecialchars($pesan['nama_mahasiswa']); ?></p>
                        <p><strong>Pesan Mahasiswa:</strong></p>
                        <p><?php echo nl2br(htmlspecialchars($pesan['pesan_mhs'])); ?></p>
                        <?php if (!empty($pesan['pesan_verifikator'])): ?>
                            <p><strong>Pesan Verifikator:</strong></p>
                            <p><?php echo nl2br(htmlspecialchars($pesan['pesan_verifikator'])); ?></p>
                        <?php endif; ?>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars($pesan['status']); ?></p>
                    </div>
                </div>

                <!-- Form Balas Pesan -->
                <div class="card">
                    <div class="card-body">
                        <h5>Balas Pesan</h5>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="balasan">Balasan Verifikator:</label>
                                <textarea class="form-control" id="balasan" name="balasan" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Balasan</button>
                            <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap dan jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Script untuk Memasukkan Navbar dan Sidebar -->
    <script>
        $(function(){
            $("#navbar-placeholder").load("navbar.html");
            $("#sidebar-placeholder").load("sidebar.html");
        });
    </script>
</body>
</html>
