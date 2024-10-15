<h2>Data Diri Mahasiswa</h2>
<form method="POST" action="/mahasiswa/update">
    <input type="hidden" name="student_id" value="<?= $mahasiswa['id'] ?>" />
    <label for="name">Nama:</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($mahasiswa['name']); ?>" required>

    <label for="major">Jurusan:</label>
    <input type="text" id="major" name="major" value="<?= htmlspecialchars($mahasiswa['major']); ?>" required>

    <button type="submit">Update</button>
</form>
