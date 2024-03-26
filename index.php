<?php 
session_start();

// memeriksa apakah variabel session login sudah dibuat atau ada isinya
if(!isset($_SESSION["login"]))   {
    header("Location: login.php");
    exit;
}

// hubungkan dengan functions.php
require 'functions.php';

// PAGINATION  
$jumlahDataPerHalaman = 3;

$paginationConfig = pagination($jumlahDataPerHalaman);
$jumlahHalaman = $paginationConfig['jumlahHalaman'];
$halamanAktif = $paginationConfig['halamanAktif'];
$awalData = $paginationConfig['awalData'];

$students = queryPagination($awalData, $jumlahDataPerHalaman);

// buat logic jika tombol cari ditekan
if(isset($_POST["cari"]))  {
    $students = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
</head>
<body>

<h1>Daftar Mahasiswa</h1>

<form action="" method="post">
    <!-- autofocus, untuk ketika pertama kali membuka website, langsung mengarah ke input
    place holder, untuk memasukkan teks background -->
    <input type="text" name="keyword" size="40" autofocus placeholder="masukkan keyword" autocomplete="off">
    <button type="submit" name="cari">Cari Data</button>
</form>
<br>

<table border="1" cellpadding="10" cellspacing="0">

    <tr>
        <th>No.</th>
        <th>Aksi</th>
        <th>Gambar</th>
        <th>Nama</th>
        <th>Nim</th>
        <th>Jurusan</th>
        <th>Email</th>
    </tr>

    <?php
    $i = 1 + $awalData;
    foreach($students as $s) :?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td>
            <a href="ubah.php?id=<?= $s["id"] ?>">ubah</a> |
            <!-- jika return nilai true, maka href dijalankan -->
            <a href="hapus.php?id=<?= $s["id"] ?>" onclick="return confirm('yakin?')";>hapus</a>
        </td>
        <td><img src="img/<?= $s["gambar"] ?>" alt="" width="50"></td>
        <td><?= $s["nama"] ?></td>
        <td><?= $s["nim"] ?></td>
        <td><?= $s["jurusan"] ?></td>
        <td><?= $s["email"] ?></td>
    </tr>
    <?php endforeach; ?>

</table>
<br>
<!-- pagenation navigation -->
<?php require 'pagination.php' ?>

<br>
<br>
<a href="tambah.php">Tambah data mahasiswa</a>
<br>
<br>
<br>
<a href="logout.php" style="font-weight: bold; font-style: italic;">logout</a>

</body>
</html>
