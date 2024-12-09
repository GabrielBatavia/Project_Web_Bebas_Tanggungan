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
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/pengumpulanBerkas.css">
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
                            <h3>Preview</h3>
                            <?php
                            // Proses file PDF dan tampilkan gambar preview
                            foreach ($pdfFiles as $pdfFile) {
                                $previewImage = 'img/' . basename($pdfFile, '.pdf') . '-preview.png'; // Path gambar preview
                                
                                // Periksa apakah gambar preview sudah ada
                                if (!file_exists($previewImage)) {
                                    // Jika belum ada, buat preview
                                    if (!getPdfPreview($pdfFile, $previewImage)) {
                                        echo "<p>Gagal membuat preview untuk file: " . basename($pdfFile) . "</p>";
                                    }
                                }
                                
                                // Menampilkan kartu dengan gambar preview
                                echo '<div class="card" style="width: 18rem;">';
                                echo '<img src="' . $previewImage . '" class="card-img-top" alt="Preview Gambar">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">Dokumen: ' . basename($pdfFile) . '</h5>';
                                echo '<a href="' . $pdfFile . '" class="btn btn-primary">Download Surat</a>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                            <div>
                                <!-- Tombol untuk membuka pop-up -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFileModal">Add File</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Pop-up -->
    <div class="modal fade" id="addFileModal" tabindex="-1" aria-labelledby="addFileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFileModalLabel">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="upload.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="fileInput">Pilih File</label>
                            <input type="file" class="form-control-file" id="fileInput" name="uploadedFile" required>
                        </div>
                        <div class="form-group">
                            <label for="fileDescription">Deskripsi File</label>
                            <textarea class="form-control" id="fileDescription" name="fileDescription" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap dan jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
