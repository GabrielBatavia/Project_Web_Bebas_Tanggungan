<?php
// Include navbar and sidebar
include 'navbar.php';
include 'sidebar.html';

// Menampilkan pesan alert dengan animasi
if (isset($_GET['success'])) {
    echo "<div class='alert alert-success animated fadeIn'>File uploaded successfully.</div>";
} elseif (isset($_GET['error'])) {
    if ($_GET['error'] === 'size') {
        echo "<div class='alert alert-danger animated fadeIn'>File size exceeds the limit (10 MB).</div>";
    } elseif ($_GET['error'] === 'type') {
        echo "<div class='alert alert-danger animated fadeIn'>Invalid file type. Only PDF files are allowed.</div>";
    } else {
        echo "<div class='alert alert-danger animated fadeIn'>File upload failed.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Meta tags dan judul -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bebas Tanggungan Prodi</title>
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
    
    <!-- Animate.css untuk animasi (Opsional tetapi disarankan) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
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
                    <h2>Bebas Tanggungan Prodi</h2>
                </div>

                <!-- Main Form -->
                <form action="upload.php" method="POST" enctype="multipart/form-data" class="upload-form" id="uploadForm">
                    <input type="hidden" name="type" value="prodi"> <!-- Menentukan tipe upload -->

                    <!-- Form 1: Tanda Terima Penyerahan Laporan Tugas Akhir/Skripsi -->
                    <div class="card mb-4 shadow-sm animated fadeInUp">
                        <div class="card-header">
                            <h5>Tanda Terima Penyerahan Laporan Tugas Akhir/Skripsi</h5>
                        </div>
                        <div class="card-body">
                            <h5>Catatan: Upload dalam bentuk PDF. (max 10 MB).</h5>
                            <div class="form-group">
                                <label for="file_upload_1">Upload File:</label>
                                <input type="file" name="file_upload_1" class="form-control file-input" required id="file_upload_1">
                                <small class="form-text text-muted">Upload 1 file: PDF. Max 10 MB.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Form 2: Tanda Terima Penyerahan Laporan PKL/Magang -->
                    <div class="card mb-4 shadow-sm animated fadeInUp delay-1">
                        <div class="card-header">
                            <h5>Tanda Terima Penyerahan Laporan PKL/Magang</h5>
                        </div>
                        <div class="card-body">
                            <h5>Upload Tanda Terima Penyerahan Laporan PKL/Magang. Jika PKL/Magang lebih dari 1 kali, 
                            berkas dijadikan 1 PDF.</h5>
                            <h5>Catatan: Upload dalam bentuk PDF. (max 10 MB).</h5>
                            <div class="form-group">
                                <label for="file_upload_2">Upload File:</label>
                                <input type="file" name="file_upload_2" class="form-control file-input" required id="file_upload_2">
                                <small class="form-text text-muted">Upload 1 file: PDF. Max 10 MB.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Form 3: Surat Bebas Kompen -->
                    <div class="card mb-4 shadow-sm animated fadeInUp delay-2">
                        <div class="card-header">
                            <h5>Surat Bebas Kompen</h5>
                        </div>
                        <div class="card-body">
                            <h5>Catatan: Upload dalam bentuk PDF. (max 10 MB).</h5>
                            <div class="form-group">
                                <label for="file_upload_3">Upload File:</label>
                                <input type="file" name="file_upload_3" class="form-control file-input" required id="file_upload_3">
                                <small class="form-text text-muted">Upload 1 file: PDF. Max 10 MB.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Form 4: Scan TOEIC -->
                    <div class="card mb-4 shadow-sm animated fadeInUp delay-3">
                        <div class="card-header">
                            <h5>Scan TOEIC</h5>
                        </div>
                        <div class="card-body">
                            <h5>Upload Scan TOEIC dengan skor minimal 450 untuk Diploma 4.</h5>
                            <p>Apabila sudah mengikuti 1x tes gratis Polinema dan 1x ujian mandiri berbayar,
                            <br>Namun nilai masih kurang, maka akan diberikan surat keterangan dari UPA Bahasa (Grapol Lantai 3).</p>
                            <h5>Catatan: Upload dalam bentuk PDF. (max 10 MB).</h5>
                            <div class="form-group">
                                <label for="file_upload_4">Upload File:</label>
                                <input type="file" name="file_upload_4" class="form-control file-input" required id="file_upload_4">
                                <small class="form-text text-muted">Upload 1 file: PDF. Max 10 MB.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Button di pojok kanan atas -->
                    <div class="upload-btn-container">
                        <button type="submit" class="btn btn-primary btn-animated" id="success" disabled>
                            <i class="fas fa-upload"></i> Upload All
                        </button>
                    </div>
                </form>      
            </main>
        </div>
    </div>

    <?php include 'footer.php';?>

    <!-- Bootstrap dan jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // JavaScript untuk mengaktifkan tombol Upload setelah semua file dipilih
        $(document).ready(function() {
            function checkFiles() {
                let allFilesSelected = true;
                $(".upload-form input[type='file']").each(function() {
                    if ($(this).val() === '') {
                        allFilesSelected = false;
                    }
                });
                if (allFilesSelected) {
                    $('#success').prop('disabled', false); // Aktifkan tombol upload
                } else {
                    $('#success').prop('disabled', true); // Nonaktifkan jika belum semua file dipilih
                }
            }

            // Cek file saat dipilih
            $(".upload-form input[type='file']").change(function() {
                checkFiles();
            });

            // Inisialisasi pengecekan saat halaman dimuat
            checkFiles();
        });

        // Script pop up button upload
        const successButton = document.querySelector('#success');

        successButton.addEventListener('click', function(event) {
            // Prevent form submission untuk menampilkan alert terlebih dahulu
            event.preventDefault();

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Berhasil mengupload file',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                // Setelah alert, submit form
                document.getElementById('uploadForm').submit();
            });
        });
    </script>
</body>

</html>
