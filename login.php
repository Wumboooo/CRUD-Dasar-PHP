<?php 
// enable session
session_start();

// hubungkan dengan functions.php, PASTIKAN SELALU DIBAGIAN ATAS UNTUK BISA MENGGUNAKAN $conn dll
require 'functions.php';

// cek cookie untuk menentukan session login masih ada atau tidak meskipun sudah close
if(isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil informasi username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM users WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username 
    if($key === hash('sha256', $row['username']))   {
        $_SESSION['login'] = true;
    }
}

// cek apakah session login sudah terbuat atau terisi atau tidak
if(isset($_SESSION["login"]))   {
    header("Location: index.php");
    exit;
}


// cek apakah tombol login sudah ditekan atau belum
if(isset($_POST["login"]))  {
    // mengambil nilai username dan password yang sudah dikirimkan melalui form dengan metode post
    $username = $_POST["username"];
    $password = $_POST["password"];

    // melakukan query dan mencari user yang sesuai
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

    // cek username
    // Memeriksa apakah hasil query mengembalikan satu baris data. Jika iya, 
    // berarti username yang dimasukkan oleh pengguna valid
    if(mysqli_num_rows  ($result) === 1) {

        // cek password
        // mengambil data hasil query dan memasukkannya kedalam array
        $row = mysqli_fetch_array($result);
        // memeriksa password yang dimasukkan user dengan hasil hash pada database
        if(password_verify($password, $row["password"])) {
            // set session
            // ketika semua validasi berhasil, melakukan pembuatan variabel login = true
            $_SESSION["login"] = true;

            // cek checkbox remember me
            if(isset($_POST['remember'])) {
                // buat cookie
                setcookie('id', $row['id'], time() + 500);
                setcookie('key', hash('sha256', $row['username']), time() + 500);
            }

            header("Location: index.php");
            exit;
        }
    }
    $error = true;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Halaman Login</title>
    </head>
    <body>
        
        <h1>Halaman Login</h1>
        
        <?php if(isset($error)) : ?>
            <p style="color: red; font-style: italic;">username / password salah</p>
        <?php endif; ?>

        <form action="" method="post">
            <ul>
                <li>
                    <label for="username">username :</label>
                    <input type="text" name="username" id="username">
                </li>
                <li>
                    <label for="password">password :</label>
                    <input type="text" name="password" id="password">
                </li>
                <li>
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">remember me</label>
                     
                </li>
                <li>
                    <button type="submit" name="login">Login</button>
                </li>
            </ul>
        </form>

    </body>
</html>