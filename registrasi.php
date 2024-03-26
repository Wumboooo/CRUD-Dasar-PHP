<?php 
session_start();

// memeriksa apakah variabel session login sudah dibuat atau ada isinya
if(!isset($_SESSION["login"]))   {
    header("Location: login.php");
    exit;
}

// hubungkan ke functions.php
require 'functions.php';

// memeriksa apakah variabel post register terisi atau terbuat
if( isset($_POST["register"])) {
    if( registration($_POST) > 0) {
        echo "<script>
                alert('user baru berhasil ditambahkan');
            </script>";
    }else{
        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>
<body>
    
<h1>Halaman Registrasi</h1>

<form action="" method="post">

    <ul>
        <li>
            <label for="username">username  :</label>
            <input type="text" name="username" id="username">
        </li>
        <li>
            <label for="password">password  :</label>
            <input type="password" name="password" id="password">
        </li>
        <li>
            <label for="confirm">confirm  :</label>
            <input type="password" name="confirm" id="confirm">
        </li>
        <li>
            <button type="submit" name="register">Register!</button>
        </li>
    </ul>

</form>

</body>
</html>