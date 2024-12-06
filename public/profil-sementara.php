<?php
// Start session atau include session handling jika diperlukan
// session_start();

// Include navbar dan sidebar
include 'navbar.html';
include 'sidebar.html';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Meta tags dan judul -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/profil.css">
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
                <!-- Bagian Profil -->
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Profil</h2>
                </div>
                <div class="row profile-container">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="card profile-card">
                            <div class="card-header">
                                <h5>Data Pribadi</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Kartu Info Individu -->
                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <h6>Nama Lengkap</h6>
                                            <p>Nama Pengguna</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <h6>NIM</h6>
                                            <p>1234567890</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <h6>Email</h6>
                                            <p>MahasiswaKeren@polinema.ac.id</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <h6>No. Telp</h6>
                                            <p>1234567890</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <h6>Status</h6>
                                            <p>Mahasiswa</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <h6>Prodi</h6>
                                            <p>D-IV Teknik Informatika</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bagian Notifikasi -->
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Notifikasi</h2>
                </div>
                <div class="row profile-container">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="card notifications-card">
                            <div class="card-body">
                                <!-- Konten Notifikasi -->
                                <div id="notifications-content">
                                    <!-- Notifikasi akan dimuat di sini -->
                                </div>
                                <!-- Paginasi -->
                                <nav aria-label="Navigasi notifikasi">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item"><a class="page-link" href="#" id="notif-prev">&laquo;</a></li>
                                        <li class="page-item active"><a class="page-link" href="#" data-page="1">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#" data-page="2">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#" data-page="3">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#" id="notif-next">&raquo;</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bagian Pertanyaan -->
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Pertanyaan</h2>
                </div>
                <div class="row profile-container">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="card questions-card">
                            <div class="card-body">
                                <!-- Konten Pertanyaan -->
                                <div id="questions-content">
                                    <!-- Pertanyaan akan dimuat di sini -->
                                </div>
                                <!-- Paginasi -->
                                <nav aria-label="Navigasi pertanyaan">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item"><a class="page-link" href="#" id="ques-prev">&laquo;</a></li>
                                        <li class="page-item active"><a class="page-link" href="#" data-page="1">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#" data-page="2">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#" data-page="3">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#" id="ques-next">&raquo;</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap dan jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://rerofya.github.io/resources/sweetalert.js"></script>
    <!-- Chart.js dan script custom -->
    <script>
        // Include navbar dan sidebar
        $(function () {
            $("#navbar-placeholder").load("navbar.html");
            $("#sidebar-placeholder").load("sidebar.html");
        });

        // Data sampel untuk notifikasi dan pertanyaan
        const notifications = [
            {
                type: 'danger',
                title: 'Berkas Ditolak!',
                message: 'Komentar Verifikator: "Kamu belum melengkapi tandatangan"'
            },
            {
                type: 'danger',
                title: 'Berkas Ditolak!',
                message: 'Komentar Verifikator: "Tolong dibaca ulang dokumennya, jangan ada typo pada penulisan nama"'
            },
            {
                type: 'success',
                title: 'Berkas Diterima!',
                message: 'Tidak ada komentar dari Verifikator'
            },
            // Tambahkan notifikasi lain sesuai kebutuhan
        ];

        const questions = [
            {
                date: '15/11/2024 Pukul 12.00',
                title: 'Pertanyaan Anda',
                message: 'Pesan : Mohon Maaf sebesar-besarnya Ibu saya Bla-bla-bla'
            },
            {
                date: '16/11/2024 Pukul 13.00',
                title: 'Pertanyaan Anda',
                message: 'Pesan : Mohon Maaf sebesar-besarnya Ibu saya Bla-bla-bla'
            },
            {
                date: '17/11/2024 Pukul 14.00',
                title: 'Berkas Diterima',
                message: 'Pesan : Mohon Maaf sebesar-besarnya Ibu saya Bla-bla-bla'
            },
            // Tambahkan pertanyaan lain sesuai kebutuhan
        ];

        // Fungsi untuk menampilkan konten dengan paginasi
        function renderContent(contentArray, contentId, page, itemsPerPage) {
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const paginatedItems = contentArray.slice(start, end);
            let contentHtml = '';
            paginatedItems.forEach(item => {
                contentHtml += `
                <div class="alert alert-${item.type || 'secondary'}">
                    <h6>${item.title}</h6>
                    <p>${item.message}</p>
                </div>`;
            });
            $(contentId).html(contentHtml);
        }

        // Inisialisasi tampilan awal
        $(document).ready(function () {
            renderContent(notifications, '#notifications-content', 1, 3);
            renderContent(questions, '#questions-content', 1, 3);
        });

        // Handler klik untuk paginasi
        $('.pagination a.page-link').on('click', function (e) {
            e.preventDefault();
            const page = $(this).data('page');
            if ($(this).parents('nav').attr('aria-label') === 'Navigasi notifikasi') {
                renderContent(notifications, '#notifications-content', page, 3);
                updatePagination('nav[aria-label="Navigasi notifikasi"]', page);
            } else {
                renderContent(questions, '#questions-content', page, 3);
                updatePagination('nav[aria-label="Navigasi pertanyaan"]', page);
            }
        });

        function updatePagination(paginationSelector, activePage) {
            $(paginationSelector + ' li').removeClass('active');
            $(paginationSelector + ` a[data-page="${activePage}"]`).parent().addClass('active');
        }
    </script>
</body>

</html>
