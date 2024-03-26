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

// ambil data dari URL
$id = $_GET["id"];

// query data mahasiswa berdasarkan id
// ambil baris pertama atau "0"
$s = query("SELECT * FROM students WHERE id = $id")[0];

// cek apakah tombol submit sudah ditekan atau belum
// bacanya "apakah elemen yang ada di dalam form post yang bernama submit true atau false"
if(isset($_POST["submit"])) {
    // cek apakah data berhasil diubah
    if ( ubah($_POST) > 0 ) {
        echo "
            <script>
                alert('Data berhasil diubah');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
        <script>
            alert('Data gagal diubah');
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
    <title>Ubah data mahasiswa</title>
</head>
<body>
    
    <h1>Ubah Data Mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $s["id"]; ?>">
    <input type="hidden" name="gambarLama" value="<?= $s["gambar"]; ?>">
        <ul>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" value="<?= $s["nama"]; ?>">
            </li>
            <li>
                <label for="nim">NIM : </label>
                <input type="text" name="nim" id="nim" value="<?= $s["nim"]; ?>">
            </li>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan" value="<?= $s["jurusan"]; ?>">
            </li>
            <li>
                <label for="email">Email : </label>
                <input type="text" name="email" id="email" value="<?= $s["email"]; ?>">
            </li>
            <li>
                <label for="gambar">Gambar : </label>
                <img src="img/<?= $s['gambar'];?>" width="40">
                <input type="file" name="gambar" id="gambar" value="<?= $s["gambar"]; ?>">
            </li>
            <li>
                <button type="submit" name="submit">Ubah</button>
            </li>
        </ul>
    
    </form>
    <br>
    <a href="index.php">Kembali</a>

</body>
</html>