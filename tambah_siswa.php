<form action="simpan_siswa.php" method="POST" enctype="multipart/form-data">
    <label>NIS (Nomor Induk):</label><br>
    <input type="text" name="nis" required><br>

    <label>Nama Lengkap:</label><br>
    <input type="text" name="nama_lengkap" required><br>

    <label>Kelas:</label><br>
    <input type="text" name="kelas"><br>

    <label>Upload Foto Kartu/Siswa:</label><br>
    <input type="file" name="foto"><br><br>

    <button type="submit">Simpan Master Data</button>
</form>