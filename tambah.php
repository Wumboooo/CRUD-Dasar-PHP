<?php 
// enable session
session_start();

// memeriksa apakah variabel session login sudah dibuat atau ada isinya
if(!isset($_SESSION["login"]))   {
    header("Location: login.php");
    exit;
}

// jangan lupa menghubungkan page ini dengan halaman sebelah
require("functions.php");

// cek apakah tombol submit sudah ditekan atau belum
// bacanya "apakah elemen yang ada di dalam form post yang bernama submit
if(isset($_POST["submit"])) {
    if ( tambah($_POST) > 0 ) {
        echo "
            <script>
                alert('Data berhasil ditambahkan');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
        <script>
            alert('Data gagal ditambahkan');
            document.location.href = 'index.php';
        </script>
    ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah data mahasiswa</title>
</head>
<body>
    
    <h1>Tambah Data Mahasiswa</h1>

    <!-- enctype, membagi array spesifically untuk file dan post lain -->
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama">
            </li>
            <li>
                <label for="nim">NIM : </label>
                <input type="text" name="nim" id="nim">
            </li>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan">
            </li>
            <li>
                <label for="email">Email : </label>
                <input type="text" name="email" id="email">
            </li>
            <li>
                <label for="gambar">Gambar : </label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Submit</button>
            </li>
        </ul>
    
    </form>
    <br>
    <a href="index.php">Kembali</a>

</body>
</html>