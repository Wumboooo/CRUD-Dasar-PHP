<?php 
// enable session
session_start();

// memeriksa apakah variabel session login sudah dibuat atau ada isinya
if(!isset($_SESSION["login"]))   {
    header("Location: login.php");
    exit;
}

    require("functions.php");

    $id = $_GET["id"];

    if ( hapus($id) > 0 ) {
        // menggunakan tag javascript untuk memunculkan notifikasi
        echo "
            <script>
                alert('Data berhasil dihapus');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
        <script>
            alert('Data berhasil dihapus');
            document.location.href = 'index.php';
        </script>
        ";
    }
?>