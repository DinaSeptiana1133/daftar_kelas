<?php
session_start();

if(isset($_SESSION["login"])){
    header("Location: ../index.php");
    exit;
}
require_once '../koneksi/db.php';

$jumlahDataPerHalaman = 2;
$jumlahData = count(query("SELECT * FROM daftar"));
$jumlahHalaman =ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$mhs = query("SELECT * FROM daftar LIMIT $awalData,$jumlahDataPerHalaman");
if(isset($_POST["cari"])){
    $mhs = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Index</title>
</head>
<body>

    <a href="logout.php">Logout</a>
    
    <h1>Daftar Mahasiswa</h1>
    <a href="tambah.php">Tambah Data</a> <br><br>

    <form action="" method="post">
        <input type="text" name="keyword" id="" size="30" autofocus placeholder="Masukan keyword pencarian.." autocomplete="off">
        <button type="submit" name="cari">Cari</button>
    </form>
    <br>

    <!-- navigation -->
    <?php if($halamanAktif > 1) : ?>
    <a href="?halaman=<?= $halamanAktif- 1; ?>">&laquo;</a>
    <?php endif; ?>

    <?php for($i=1; $i <= $jumlahHalaman; $i++) : ?>
        <?php if($i == $halamanAktif) : ?>
            <a href="?halaman=<?= $i; ?>" style="font-weight: bold; color:red;"><?= $i; ?></a>
        <?php else : ?>
            <a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if($halamanAktif < $jumlahHalaman) : ?>
    <a href="?halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>
    <?php endif; ?>

    <br>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>nama</th>
            <th>email</th>
            <th>alamat</th>
            <th>tanggal lahir</th>
            <th>umur</th>
            <th>jenis kelamin</th>
        </tr>

        <?php $i=1; ?>
        <?php foreach($mhs as $row) : ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><img src="../img/<?php echo $row["gambar"]; ?>" width="70" alt=""></td>
            <td><?php echo $row["nama"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["alamat"]; ?></td>
            <td><?php echo $row["tanggal_lahir"]; ?></td>
            <td><?php echo $row["umur"]; ?></td>
            <td><?php echo $row["jenis_kelamin"]; ?></td>
        </tr>
        <?php  $i++; ?>
        <?php endforeach; ?>
    </table>
</body>
</html>