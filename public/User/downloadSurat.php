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
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/pengumpulanBerkas.css">
    
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
                    <h2>Download Surat Akhir</h2>
                </div>
            <!-- Laporan Tugas Akhir -->
                <div class="card">
                    <div class="card-header">
                        <h5>Download Surat Akhir</h5>
                    </div>
                    <div class="card-body">
                    <div class="pt-1 pb-2 mb-3 border-bottom">
                        <h5>Langkah-Langkah</h5>
                    </div>
                    <div>
                        <ul>
                            <li>Pastikan 7 berkas wajib telah diunggah dan diverifikasi oleh admin untuk dapat mengunduh dokumen</li>
                            <li>Unduh dan cetak template dokumen pada kertas A4</li>
                            <li>Temui Verifikator 1 (Lantai 7) dan Verifikator 2 (Lantai 6) untuk tanda tangan</li>
                            <li>Serahkan dokumen ke Admin Kajur untuk tanda tangan terakhir</li>
                            <li>Ambil kembali surat yang sudah ditandatangani dalam 1-2 hari kerja</li>
                            <li>Scan dan upload berkas yang sudah ditandatangani</li>
                        </ul>
                    </div>
                    <div class="preview">
                        <h3>Preview</h3><br>
                        <img src="../img/Surat-Bebas-Tanggungan.png" alt="Preview Gambar"><br>
                            <div>
                                <!-- Tombol Download yang telah diubah -->
                                <a href="../../app/uploads/file_675c43f6a6faf.pdf" download class="btn btn-primary">Download Surat</a>
                            </div>
                            <br>
                            <!-- <button type="submit" class="btn btn-primary">Add File</button> -->
                        </div>
                    </div>
                </div>
        <!-- End Main -->
        </main>
    </div>
    </div>
    <?php include 'footer.php';?>

    <!-- Bootstrap dan jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js dan script custom -->
    <script>
        // Include navbar and sidebar
        $(function () {
            $("#navbar-placeholder").load("navbar.php");
            $("#sidebar-placeholder").load("sidebar.html");
        });
    </script>
</body>
</html>
