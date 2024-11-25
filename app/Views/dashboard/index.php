<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Data Tanggungan Mahasiswa</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mahasiswa</th>
                <th>Berkas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tanggungan as $item): ?>
                <tr>
                    <td><?= $item['id_tanggungan']; ?></td>
                    <td><?= $item['mahasiswa']; ?></td>
                    <td><?= $item['nama_berkas']; ?></td>
                    <td><?= $item['status']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
