<?php
session_start();

// Sertakan Controller.php melalui HelpDeskController.php
require_once '../../app/controllers/HelpDeskController.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.html");
    exit;
}

// Jika form disubmit, proses data melalui controller
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_pesan'])) {
    require_once '../../app/controllers/HelpDeskController.php';
    $controller = new HelpDeskController();
    $controller->sendMessage();
}

// Cek status untuk menampilkan toast
$status = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $status = 'success';
    } elseif ($_GET['status'] == 'error') {
        $status = 'error';
    } elseif ($_GET['status'] == 'validation_error') {
        $status = 'validation_error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags dan judul -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpDesk</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Import Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/helpdesk.css">
    
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
                <div class="pt-4 pb-2 mb-3 border-bottom border-dark">
                    <h2>HelpDesk</h2>
                </div>
                <div class="header">
                    <img src="../img/image10.png" alt="" class="g1">
                    <div class="header-text">
                        <h5 class="header-title">Pertanyaan Umum</h5>
                        <p class="header-title2">
                            Beberapa Pertanyaan yang sering ditanyakan
                        </p>
                    </div>
                    
                    <img src="../img/image11.png" alt="" class="g2">
                </div>
                <!-- Pertanyaan Umum (Anda dapat menambahkan lebih banyak pertanyaan sesuai kebutuhan) -->
                <div class="card">
                    <div class="card-body1">
                        <p class="bold">Pertanyaan : Apa yang dimaksud dengan surat Bebas Tanggungan?</p>
                        <i class="fa-solid fa-chevron-down" data-target="#card-body23"></i>
                    </div>
                    <div class="card-divider"></div>
                    <div id="card-body23" class="card-body23" style="display: none;">
                        <p class="semi">Jawaban: Surat Bebas Tanggungan adalah...</p>
                    </div>
                </div>
                <!-- Tambahkan pertanyaan lain di sini -->

                <!-- Form Pengiriman Pesan -->
                <div class="middle-text">
                    <h2>Punya pertanyaan spesifik/Urgent?</h2>
                </div>
                <div class="card card61">
                    <div class="body6">
                        <!-- Form untuk Admin Prodi -->
                        <div class="kiri">
                            <img src="../img/user-profile.jpg" alt="Profile" class="rounded-circle" height="88">
                            <h3>Admin Prodi</h3>
                            <p>1-2 Hari Kerja</p>
                            <form method="POST" action="helpDesk.php">
                                <textarea name="pesan_mhs" class="form-control" rows="3" style="width: 357px; height: 133px;" placeholder="Ketik pesan disini..." required></textarea>
                                <input type="hidden" name="tujuan_id_jabatan" value="1">
                                <button type="submit" name="submit_pesan" class="btn btn-primary mt-2">Kirim ke Admin Prodi</button>
                            </form>
                        </div>
                        <div class="vertical-divider"></div>
                        <!-- Form untuk Verifikator lt 7 -->
                        <div class="kanan">
                            <img src="../img/user-profile.jpg" alt="Profile" class="rounded-circle" height="88">
                            <h3>Verifikator lt 7</h3>
                            <p>1-2 Hari Kerja</p>
                            <form method="POST" action="helpDesk.php">
                                <textarea name="pesan_mhs" class="form-control" rows="3" style="width: 357px; height: 133px;" placeholder="Ketik pesan disini..." required></textarea>
                                <input type="hidden" name="tujuan_id_jabatan" value="2">
                                <button type="submit" name="submit_pesan" class="btn btn-primary mt-2">Kirim ke Verifikator lt 7</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- footer -->
                <div id="footer-placeholder"></div>

        <!-- End Main -->
        </main>
    </div>
    </div>

    <div id="toast-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: none;">
        <div id="toast-message" style="background: #143273; color: white; padding: 10px 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">
            Pesan anda telah terkirim!
        </div>
    </div>    

    <!-- Bootstrap dan jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js dan script custom -->
    <script>
    $(function () {
        $("#navbar-placeholder").load("navbar.php");
        $("#sidebar-placeholder").load("sidebar.html");
        $("#footer-placeholder").load("footer.html");
    });

    $(document).ready(function () {
        $('.fa-chevron-down').on('click', function () {
            const target = $(this).data('target');
            $(target).slideToggle();
            $(this).toggleClass('fa-chevron-down fa-chevron-up');
        });

        // Tampilkan toast berdasarkan status
        <?php if ($status == 'success'): ?>
            $('#toast-message').text('Pesan anda telah terkirim!');
            $('#toast-container').fadeIn();
            setTimeout(() => {
                $('#toast-container').fadeOut();
            }, 2000);
        <?php elseif ($status == 'error'): ?>
            alert('Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.');
        <?php elseif ($status == 'validation_error'): ?>
            alert('Pesan tidak boleh kosong dan tujuan harus valid.');
        <?php endif; ?>
    });

    document.querySelectorAll('button[name="submit_pesan"]').forEach(button => {
        button.addEventListener('click', () => {
            // Tidak perlu menambahkan event listener di sini karena toast ditangani oleh PHP
        });
    });
    </script>
</body>
</html>
