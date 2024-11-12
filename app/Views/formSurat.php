<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Pengajuan Surat Bebas Tugas Akhir</title>
</head>
<body>
    <h1>Form Pengajuan Surat Bebas Tugas Akhir</h1>
    <form action="index.php?action=ajukanSurat" method="POST">
        <label for="nomorSurat">Nomor Surat:</label>
        <input type="text" id="nomorSurat" name="nomorSurat" required><br><br>

        <label for="jenisSurat">Jenis Surat:</label>
        <select id="jenisSurat" name="jenisSurat" required>
            <option value="Bebas Tugas Akhir">Bebas Tugas Akhir</option>
            <option value="Bebas Perpustakaan">Bebas Perpustakaan</option>
            <option value="Bebas UKT">Bebas UKT</option>
        </select><br><br>

        <label for="tanggalPembuatan">Tanggal Pembuatan:</label>
        <input type="date" id="tanggalPembuatan" name="tanggalPembuatan" required><br><br>

        <label for="statusDisetujui">Status Persetujuan:</label>
        <input type="checkbox" id="statusDisetujui" name="statusDisetujui" value="1">
        <label for="statusDisetujui">Sudah Disetujui</label><br><br>

        <button type="submit">Ajukan Surat</button>
    </form>
</body>
</html>
