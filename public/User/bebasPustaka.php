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
        echo "<div class='alert alert-danger animated fadeIn'>Invalid file type. Please upload the correct file format.</div>";
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
    <title>Bebas Pustaka</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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
                    <h2>Bebas Pustaka</h2>
                </div>

                <!-- Main Form -->
                <form action="upload.php" method="POST" enctype="multipart/form-data"
                    class="upload-form" id="uploadForm">
                    <input type="hidden" name="type" value="bebasPustaka"> <!-- Menentukan tipe upload -->

                    <!-- Form: Bebas Pustaka -->
                    <div class="card mb-4 shadow-sm animated fadeInUp">
                        <div class="card-header">
                            <h5>Bebas Pustaka</h5>
                        </div>
                        <div class="card-body">
                            <h6>Selesaikan terlebih dahulu Persyaratan Bebas Pustaka di
                                <a href="https://library.polinema.ac.id/" target="_blank">library.polinema.ac.id</a>
                                dan Upload Surat Keterangan Bebas Pustaka di sini.
                            </h6><br>
                            <h5>Catatan: Upload dalam bentuk PDF dan sudah bertanda tangan (max 10 MB).</h5>
                            <div class="form-group">
                                <label for="file_upload_1">Upload File:</label>
                                <input type="file" name="file_upload_1" class="form-control file-input" required
                                    id="file_upload_1">
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

    <?php include 'footer1Hal.php';?>

    <!-- Bootstrap dan jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // JavaScript untuk mengaktifkan tombol Upload setelah semua file dipilih
        $(document).ready(function () {
            function checkFiles() {
                let allFilesSelected = true;
                $(".upload-form input[type='file']").each(function () {
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

        //Fix whatever happened on this toasts later.
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
