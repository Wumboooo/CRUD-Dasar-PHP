<?php 
// membuat variabel global untuk koneksi server mysqli
$conn = mysqli_connect("localhost","root","", "phpdasar");

// membuat fungsi untuk mengambil dan mengubah array menjadi associative array
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data) {
    global $conn;
    // ambil data dari tiap elemen dalam form
    // htmlspecialchars supaya user tidak bisa input elemen html
    $nama = htmlspecialchars($data["nama"]);
    $nim = htmlspecialchars($data["nim"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $email = htmlspecialchars($data["email"]);

    // upload gambar
    $gambar = upload();
    
    // jika 
    if( !$gambar )  {
        return false;
    }

    // query insert data
    $query = "INSERT INTO students VALUES ('', '$nama', '$nim', '$jurusan', '$email', '$gambar')";
    mysqli_query($conn, $query);

    // kembalikan nilai affected row yang nantinya akan digunakan untuk validasi apakah datanya berhasil dimasukkan atau tidak
    return mysqli_affected_rows($conn);
}

function upload()   {
    // ambil data dari array FILES, tempat penyimpanan sementara
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // validasi, wajib upload gambar
    // "4" pada error berarti tidak ada gambar yang diupload, cek google untuk istilah lain error
    // masukkan nilai false ke post
    if( $error === 4) {
        echo "<script>
            alert('masukkin file nya ges')
        </script>";
        return false;
    }

    // cek harus gambar, selain gambar tidak bisa
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'gif'];
    // ambil ekstensi gambar dari namaFile
    $ekstensiGambar = explode('.', $namaFile);
    // setelah dipecah misalnya ['leo', 'alexander'] ambil yang paling akhir, jangan [1]
    // strtolower, mengubah semuanya menjadi lower case JPG to jpg
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    // in_array, untuk mencari string pada array
    if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
        echo "<script>
            alert('bukan gambar itu ges')
        </script>";
        return false;
    }

    if( $ukuranFile > 1000000 ) {
        // dalam byte
        echo "<script>
            alert('ukuran gambar terlalu besar ges')
        </script>";
        return false;
    }

    // lolos pengecekan, bisa masukkan ke directory asli
    // generate nama nama baru supaya user dengan namaFile yang sama tidak replacing
    $namaFileBaru = uniqid();
    $namaFileBaru .='.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}

function hapus($id) {
    global $conn;
    // tentukan apa yang mau dihapus, kita masukkan id
    mysqli_query($conn,"DELETE FROM students WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function ubah($data)  {
    global $conn;
    // ambil data dari tiap elemen dalam form
    // htmlspecialchars supaya user tidak bisa input elemen html
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $nim = htmlspecialchars($data["nim"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $email = htmlspecialchars($data["email"]);
    // ambil data gambarLama 
    $gambarLama = htmlspecialchars($data["gambarLama"]);
    
    // cek apakah user pilih gambar baru atau tidak
    // iya, replace gambarLama, tidak, jalankan upload
    if( $_FILES['gambar']['error'] === 4)   {
        $gambar = $gambarLama;
    }else{
        $gambar = upload();
    }

    $query = "UPDATE students SET nama = '$nama',nim = '$nim',jurusan = '$jurusan',email = '$email',gambar = '$gambar' WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cari($keyword) {
    global $conn;
    // LIKE, supaya input atau keyword tidak perlu sama persis, dan menggunakan LOWER agar case-insensitive
    $query = "SELECT * FROM students WHERE LOWER(nama) LIKE LOWER('%$keyword%') OR LOWER(nim) LIKE LOWER('%$keyword%') OR LOWER(jurusan) LIKE LOWER('%$keyword%') OR LOWER(email) LIKE LOWER('%$keyword%')";
    return query($query);
}

function registration($data) {
    global $conn;

    // konversi semua character menjadi lower case
    // mysqli_real_escape_string, untuk menghindari sql injection
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $confirm = mysqli_real_escape_string($conn, $data["confirm"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        echo "<script>
                alert('username sudah digunakan');
                </script>";
        return false;
    }

    // cek konfirmasi password
    if( $password !== $confirm )    {
        echo "<script>
                alert('konfirmasi password tidak sesuai');
                </script>";
        return false;
    }else {
        echo "<script>
                alert('Registrasi gagal');
            </script>";
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);
}
function pagination($jumlahDataPerHalaman) {
    $jumlahData = count(query("SELECT * FROM students"));
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
    $halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    return [
        'jumlahHalaman' => $jumlahHalaman,
        'halamanAktif' => $halamanAktif,
        'awalData' => $awalData,
    ];
}

function queryPagination($awalData, $jumlahDataPerHalaman) {
    return query("SELECT * FROM students LIMIT $awalData, $jumlahDataPerHalaman");
}

?>