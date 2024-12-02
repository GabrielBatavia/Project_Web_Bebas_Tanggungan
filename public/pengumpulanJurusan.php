<?php
// Include navbar and sidebar
include 'navbar.html';
include 'sidebar.html';

if (isset($_GET['success'])) {
    echo "<div class='alert alert-success'>File uploaded successfully.</div>";
} elseif (isset($_GET['error'])) {
    echo "<div class='alert alert-danger'>File upload failed.</div>";
} elseif (isset($_GET['error']) && $_GET['error'] === 'size') {
    echo "<div class='alert alert-danger'>File size exceeds the limit (10 MB).</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags dan judul -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bebas Tanggungan Jurusan</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/pengumpulanBerkas.css">
    
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
                    <h2>Bebas Tanggungan Jurusan</h2>
                </div>
                <!-- Laporan Tugas Akhir -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Laporan Tugas Akhir/Skripsi</h5>
                    </div>
                    <div class="card-body">
                        <h5>Catatan: Upload dalam bentuk PDF dan sudah bertanda tangan (max 10 MB).</h5>
                        <form action="../app/controllers/PengumpulanController.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_tanggungan" value="1"> <!-- Example value -->
                            <div class="form-group">
                                <label for="file_upload">Upload File:</label>
                                <input type="file" name="file_upload" class="form-control" required>
                                <small class="form-text text-muted">Upload 1 supported file: PDF. Max 10 MB.</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Bebas Tanggungan Jurusan</h2>
                </div>
                <!-- Laporan Tugas Akhir -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Laporan Tugas Akhir/Skripsi</h5>
                    </div>
                    <div class="card-body">
                        <h5>Catatan: Upload dalam bentuk PDF dan sudah bertanda tangan (max 10 MB).</h5>
                        <form action="../app/controllers/PengumpulanController.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_tanggungan" value="1"> <!-- Example value -->
                            <div class="form-group">
                                <label for="file_upload">Upload File:</label>
                                <input type="file" name="file_upload" class="form-control" required>
                                <small class="form-text text-muted">Upload 1 supported file: PDF. Max 10 MB.</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Bebas Tanggungan Jurusan</h2>
                </div>
                <!-- Laporan Tugas Akhir -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Laporan Tugas Akhir/Skripsi</h5>
                    </div>
                    <div class="card-body">
                        <h5>Catatan: Upload dalam bentuk PDF dan sudah bertanda tangan (max 10 MB).</h5>
                        <form action="../app/controllers/PengumpulanController.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_tanggungan" value="1"> <!-- Example value -->
                            <div class="form-group">
                                <label for="file_upload">Upload File:</label>
                                <input type="file" name="file_upload" class="form-control" required>
                                <small class="form-text text-muted">Upload 1 supported file: PDF. Max 10 MB.</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap dan jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
