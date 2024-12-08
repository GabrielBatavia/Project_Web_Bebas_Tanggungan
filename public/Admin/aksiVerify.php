<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inisialisasi variabel PHP dengan data dummy
$name = "Gabriel Batavia Xaverius";
$uploadDate = "16 Mei 2024";
$time = "09.40";
$fileName = "Berkas Pengumpulan Gabriel Batavia.pdf";
$programStudy = "Teknik Informatika";

// Data file uploadan
$uploadedFiles = [
    "Surat_Bebas_Tanggungan",
    "Surat_Bebas_PKL",
    "Surat_Bebas_3"
];

// Status options
$statusOptions = [
    "" => "Pilih Status",
    "approved" => "Disetujui",
    "rejected" => "Ditolak"
];

// Catatan
$notes = "";

// Gambar preview
$previewImage = "../img/Surat-Bebas-Tanggungan.png";
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
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/toast.css">
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
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10">
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Berkas Tugas Akhir Skripsi</h2>
                </div>

                <div class="d-flex row">
                    <div class="btn-group justify-content-start col-lg-6">
                        <h3>Berkas Tugas Akhir Skripsi</h3>
                    </div>
                    <div class="input-group justify-content-end col-lg-6">
                        <button type="button" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-outline-secondary ml-2">Batal</button>
                    </div>
                </div> <br><br>

                <div class="row">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <th>
                                    <div class="card">
                                        <div class="card-header">
                                            Detail
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <tr>
                                                    <td>Name</td>
                                                    <td><?php echo htmlspecialchars($name); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Upload Date</td>
                                                    <td><?php echo htmlspecialchars($uploadDate); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Time</td>
                                                    <td><?php echo htmlspecialchars($time); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>File Name</td>
                                                    <td><?php echo htmlspecialchars($fileName); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Program Study</td>
                                                    <td><?php echo htmlspecialchars($programStudy); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </th>
                            </tr>

                            <tr>
                                <th>
                                    <div class="card">
                                        <div class="card-header">
                                            File
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <?php foreach ($uploadedFiles as $file) : ?>
                                                    <li class="list-group-item">
                                                        <button class="btn btn-outline-secondary file-uploadan">
                                                            <?php echo htmlspecialchars($file); ?>
                                                        </button>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </th>
                            </tr>

                            <tr>
                                <th>
                                    <div class="card">
                                        <div class="card-header">
                                            Aksi
                                        </div>
                                        <div class="card-body">
                                            <form method="post">
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <?php foreach ($statusOptions as $value => $label) : ?>
                                                            <option value="<?php echo htmlspecialchars($value); ?>">
                                                                <?php echo htmlspecialchars($label); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="notes">Catatan</label>
                                                    <textarea class="form-control" id="notes" name="notes"
                                                        style="min-height: 150px;"><?php echo htmlspecialchars($notes); ?></textarea>
                                                </div>
                                                <a id="cetak" class="btn btn-primary">Cetak</a>
                                            </form>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                Preview
                            </div>
                            <div class="card-body d-flex justify-content-center">
                                <img src="<?php echo htmlspecialchars($previewImage); ?>" alt="Bebas Tanggungan"
                                    style="scale: 0.75; border: solid black 2px;">
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div id="toast-container" class="position-fixed p-3"></div>

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
</body>

</html>
