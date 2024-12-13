<?php
// public/Admin/cekVerify.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.html");
    exit;
}

require_once __DIR__ . '/../../app/controllers/CekVerifyController.php';

$cekVerifyController = new CekVerifyController();

// Mendapatkan id_jabatan dan id_verifikator dari session
$id_jabatan = $_SESSION['id_jabatan'];
$id_verifikator = $_SESSION['id_verifikator'] ?? 0;

// Untuk testing, NIM diset statis. Anda bisa menggantinya sesuai kebutuhan
$nim = '2341720184'; 

// Inisialisasi variabel untuk pesan
$message = '';
$messageType = '';

// Jika form disubmit untuk update status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tanggungan']) && isset($_POST['id_verifikator'])) {
        $tanggunganData = $_POST['tanggungan'];
        $id_verifikator_post = $_POST['id_verifikator'];

        // Format $tanggunganData to pass to controller
        // Each tanggungan has 'status' and 'komentar'
        $processedData = [];
        foreach ($tanggunganData as $id_tanggungan => $data) {
            $processedData[] = [
                'id_tanggungan' => $id_tanggungan,
                'status' => $data['status'],
                'komentar' => $data['komentar']
            ];
        }

        if ($cekVerifyController->updateStatusAndKomentar($id_verifikator_post, $processedData)) {
            $message = "Semua status berkas berhasil diperbarui.";
            $messageType = "success";
        } else {
            $message = "Gagal memperbarui beberapa status berkas.";
            $messageType = "danger";
        }
    } else {
        $message = "Data tidak lengkap.";
        $messageType = "warning";
    }
}

// Mendapatkan data mahasiswa dan berkas
$mahasiswa = $cekVerifyController->getMahasiswaByNIM($nim);
if ($mahasiswa) {
    $files = $cekVerifyController->getFilesByNIMAndJabatan($nim, $id_jabatan);
} else {
    $message = "Mahasiswa dengan NIM {$nim} tidak ditemukan.";
    $messageType = "warning";
}

// Variabel untuk menampilkan data
if ($mahasiswa) {
    $name = $mahasiswa['nama'];
    $uploadDate = "16 Mei 2024"; // Anda bisa mengganti ini sesuai dengan data yang relevan
    $time = "09.40"; // Anda bisa mengganti ini sesuai dengan data yang relevan
    $fileName = "Berkas Pengumpulan {$mahasiswa['nama']}.pdf"; // Contoh
    $programStudy = $mahasiswa['program_studi'];
    $previewImage = "../img/Surat-Bebas-Tanggungan.png"; // Pastikan gambar ada
} else {
    // Jika mahasiswa tidak ditemukan, set dummy data atau biarkan kosong
    $name = "";
    $uploadDate = "";
    $time = "";
    $fileName = "";
    $programStudy = "";
    $previewImage = "";
}

// Status options
$statusOptions = [
    "" => "Pilih Status",
    "selesai" => "Disetujui",
    "Ditolak" => "Ditolak"
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags dan judul -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Verifikasi</title>
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
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10">
                <!-- Header -->
                <div class="pt-4 pb-2 mb-3 border-bottom">
                    <h2>Berkas Tugas Akhir Skripsi</h2>
                </div>

                <!-- Tombol Simpan dan Batal -->
                <div class="d-flex row mb-4">
                    <div class="btn-group justify-content-start col-lg-6">
                        <h3>Berkas Tugas Akhir Skripsi</h3>
                    </div>
                    <div class="input-group justify-content-end col-lg-6">
                        <button type="submit" form="updateForm" id="simpanButton" class="btn btn-primary" disabled>Simpan</button>
                        <button type="button" class="btn btn-outline-secondary ml-2" onclick="window.history.back();">Batal</button>
                    </div>
                </div>

                <!-- Menampilkan Pesan -->
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo htmlspecialchars($messageType); ?> alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($message); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($nim) && isset($mahasiswa)): ?>
                    <form id="updateForm" method="post">
                        <!-- Hidden input untuk id_verifikator -->
                        <input type="hidden" name="id_verifikator" value="<?php echo htmlspecialchars($id_verifikator); ?>">

                        <div class="row">
                            <!-- Kolom Utama: Detail, File, Aksi -->
                            <div class="col-md-6">
                                <!-- Card Detail -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Detail
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <tr>
                                                <td><strong>Name</strong></td>
                                                <td><?php echo htmlspecialchars($name); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Upload Date</strong></td>
                                                <td><?php echo htmlspecialchars($uploadDate); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Time</strong></td>
                                                <td><?php echo htmlspecialchars($time); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>File Name</strong></td>
                                                <td><?php echo htmlspecialchars($fileName); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Program Study</strong></td>
                                                <td><?php echo htmlspecialchars($programStudy); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Card File -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        File
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <?php foreach ($files as $file) : ?>
                                                <li class="list-group-item">
                                                    <button type="button" class="btn btn-outline-secondary file-uploadan <?php echo !empty($file['status']) ? 'status-set' : ''; ?>" 
                                                        id="file-<?php echo htmlspecialchars($file['id_tanggungan']); ?>" 
                                                        data-id_tanggungan="<?php echo htmlspecialchars($file['id_tanggungan']); ?>" 
                                                        data-nama_file="<?php echo htmlspecialchars($file['nama_file']); ?>" 
                                                        data-status="<?php echo htmlspecialchars($file['status']); ?>" 
                                                        data-komentar="<?php echo htmlspecialchars($file['deskripsi'] ?? ''); ?>">
                                                        <?php echo htmlspecialchars($file['nama_file']); ?>
                                                        <?php if (!empty($file['status'])): ?>
                                                            <span class="badge badge-success ml-2">Sudah Diisi</span>
                                                        <?php endif; ?>
                                                    </button>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Card Aksi -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Aksi
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="current_file">Nama File</label>
                                            <input type="text" class="form-control" id="current_file" readonly>
                                            <!-- Hidden input untuk id_tanggungan -->
                                            <input type="hidden" id="current_id_tanggungan" name="current_id_tanggungan" value="">
                                        </div>

                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" required>
                                                <?php foreach ($statusOptions as $value => $label) : ?>
                                                    <option value="<?php echo htmlspecialchars($value); ?>">
                                                        <?php echo htmlspecialchars($label); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="komentar">Catatan</label>
                                            <textarea class="form-control" id="komentar" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Preview -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Preview
                                    </div>
                                    <div class="card-body d-flex justify-content-center align-items-center" style="height: 100%;">
                                        <?php if (!empty($previewImage)): ?>
                                            <img src="<?php echo htmlspecialchars($previewImage); ?>" alt="Bebas Tanggungan"
                                                style="width: 100%; max-width: 400px; border: solid black 2px;">
                                        <?php else: ?>
                                            <p>Tidak ada gambar preview.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>

            </main>
        </div>
    </div>

    <div id="toast-container" class="position-fixed p-3"></div>

    <!-- Bootstrap dan jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js dan script custom -->
    <script>
        $(function () {
            $("#navbar-placeholder").load("navbar.php");
            $("#sidebar-placeholder").load("sidebar.html");
        });

        // Show Toast
        function showToast(message, type = 'light') {
            const toastHTML = `
        <div class="toast align-items-center text-white bg-${type} mt-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div>
                <div class="toast-header">
                    <strong class="mr-auto">Sistem Bebas Tanggungan</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">&times;</button>
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

        <?php if (!empty($message)): ?>
            showToast("<?php echo htmlspecialchars($message); ?>", "<?php echo htmlspecialchars($messageType); ?>");
        <?php endif; ?>

        // JavaScript to handle file selection and track changes
        let changes = {};
        let totalFiles = <?php echo count($files); ?>;
        let filesWithStatus = 0;

        // Initialize filesWithStatus based on existing statuses
        <?php foreach ($files as $file): ?>
            <?php if (!empty($file['status'])): ?>
                filesWithStatus++;
            <?php endif; ?>
        <?php endforeach; ?>

        // Function to check if all statuses are set
        function checkAllStatuses() {
            // Calculate total statuses set either via existing or changes
            let currentFilesWithStatus = 0;
            $('.file-uploadan').each(function () {
                const id_tanggungan = $(this).data('id_tanggungan');
                // Check if there's a change for this file
                if (changes[id_tanggungan] && changes[id_tanggungan].status !== "") {
                    currentFilesWithStatus++;
                } else if ($(this).data('status') !== "") {
                    currentFilesWithStatus++;
                }
            });

            if (currentFilesWithStatus === totalFiles) {
                $('#simpanButton').prop('disabled', false);
            } else {
                $('#simpanButton').prop('disabled', true);
            }
        }

        // Initial check
        checkAllStatuses();

        $('.file-uploadan').click(function () {
            const id_tanggungan = $(this).data('id_tanggungan');
            const nama_file = $(this).data('nama_file');
            const status = changes[id_tanggungan] ? changes[id_tanggungan].status : $(this).data('status');
            const komentar = changes[id_tanggungan] ? changes[id_tanggungan].komentar : $(this).data('komentar');

            // Set current file in aksi card
            $('#current_file').val(nama_file);
            $('#current_id_tanggungan').val(id_tanggungan);
            $('#status').val(status);
            $('#komentar').val(komentar);

            // Highlight selected file
            $('.file-uploadan').removeClass('active');
            $(this).addClass('active');
        });

        // Handle changes in Aksi card
        $('#status, #komentar').on('change keyup', function () {
            const id_tanggungan = $('#current_id_tanggungan').val();
            const status = $('#status').val();
            const komentar = $('#komentar').val();

            if (id_tanggungan) {
                changes[id_tanggungan] = {
                    status: status,
                    komentar: komentar
                };
            }

            checkAllStatuses();
        });

        // When 'Simpan' button is clicked, populate the form with changes
        $('button[type="submit"]').click(function () {
            // Remove previous hidden inputs
            $('input[name^="tanggungan["]').remove();

            // Populate the form with changes
            for (const [id, data] of Object.entries(changes)) {
                // Create hidden inputs for each change
                const inputs = `
                    <input type="hidden" name="tanggungan[${id}][status]" value="${data.status}">
                    <input type="hidden" name="tanggungan[${id}][komentar]" value="${data.komentar}">
                `;
                $('#updateForm').append(inputs);
            }

            // After appending inputs, re-check all statuses
            checkAllStatuses();
        });

        // Prevent form submission if not all statuses are set
        $('form#updateForm').on('submit', function(e) {
            if ($('#simpanButton').prop('disabled')) {
                e.preventDefault();
                showToast("Silakan lengkapi status semua berkas sebelum menyimpan.", "warning");
            }
        });
    </script>
</body>

</html>
