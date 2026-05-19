<?php
// Memanggil koneksi ke database
include "koneksi.php";

// Mengambil data dari tabel siswa
$query = mysqli_query($koneksi, "SELECT * FROM siswa");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Data Siswa</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        tr:hover { background-color: #f9f9f9; }
        .btn-tambah { background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
        .btn-edit { color: blue; text-decoration: none; }
        .btn-hapus { color: red; text-decoration: none; }
    </style>
</head>
<body>

    <h2>Daftar Master Data Siswa</h2>
    
    <a href="tambah_siswa.php" class="btn-tambah">+ Tambah Siswa Baru</a>

    <table>
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama Lengkap</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Melakukan perulangan data dari database
            while($data = mysqli_fetch_array($query)) { 
            ?>
            <tr>
                <td><?php echo $data['nis']; ?></td>
                <td><?php echo $data['nama_lengkap']; ?></td>
                <td><?php echo $data['kelas']; ?></td>
                <td>
                    <?php echo ($data['status_aktif'] == 'Y') ? "Aktif" : "Tidak Aktif"; ?>
                </td>
                <td>
                    <a href="edit_siswa.php?id=<?php echo $data['nis']; ?>" class="btn-edit">Edit</a> | 
                    <a href="hapus_siswa.php?id=<?php echo $data['nis']; ?>" 
                       class="btn-hapus" 
                       onclick="return confirm('Yakin mau hapus data <?php echo $data['nama_lengkap']; ?>?')">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>