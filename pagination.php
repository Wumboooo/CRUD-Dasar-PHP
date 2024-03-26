<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- buat tombol panah kiri -->
    <?php if($halamanAktif > 1) : ?>
        <a href="?halaman=<?= $halamanAktif - 1; ?>">&laquo;</a>
    <?php endif; ?>

    <!-- buat interface halaman  -->
    <!-- untuk mengetahui dihalaman berapa kita berada -->
    <?php for($i = 1; $i <= $jumlahHalaman; $i++) :?>
        <?php if( $i == $halamanAktif) : ?>
            <a href="?halaman=<?= $i; ?>" style="font-weight: bold; color: red;"><?= $i ?></a>
        <?php else : ?>
            <a href="?halaman=<?= $i; ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <!-- buat tombol panah kanan -->
    <?php if($halamanAktif < $jumlahHalaman) :?>
    <a href="?halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>
    <?php endif; ?>
</body>
</html>