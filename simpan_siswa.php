<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "nama_database_mu");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis = $_POST['nis'];
    $nama = $_POST['nama_lengkap'];
    $kelas = $_POST['kelas'];

    // Proses Foto
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $path = "img/" . $foto;

    // Pindahkan file foto ke folder 'img'
    if (move_uploaded_file($tmp, $path)) {
        // Query Insert ke Master Data
        $sql = "INSERT INTO siswa (nis, nama_lengkap, kelas, foto_siswa) 
                VALUES ('$nis', '$nama', '$kelas', '$foto')";
        
        if (mysqli_query($koneksi, $sql)) {
            echo "Master Data Siswa berhasil disimpan!";
        } else {
            echo "Gagal: " . mysqli_error($koneksi);
        }
    }
}
?>