<?php
session_start();

if(isset($_SESSION["login"])){
    header("Location: ../index.php");
    exit;
}
require_once '../koneksi/db.php';

// konfigurasi pagination
$jumlahDataPerHalaman = 2;
// $result = mysqli_query($conn, "SELECT * FROM mahasiswa");
// $jumlahData = mysqli_num_rows($result);
$jumlahData = count(query("SELECT * FROM daftar"));
$jumlahHalaman =ceil($jumlahData / $jumlahDataPerHalaman);
// var_dump($jumlahHalaman);
// if(isset($_GET["halaman"])){
//     $halamanAktif = $_GET["halaman"];
// } else {
//     $halamanAktif = 1;
// }

$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
// jika halaman =2 awal data =2
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$mhs = query("SELECT * FROM daftar LIMIT $awalData,$jumlahDataPerHalaman");
// $mhs = query("SELECT * FROM mahasiswa ORDER BY id ASC");

// tombol cari diklik
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
    
    <h1>Daftar Siswa</h1>
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
            <th>Aksi</th>
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
            <td>
                <a href="edit.php?id=<?php echo $row["id"]; ?>">Edit</a> |
                <a href="hapus.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('hapus data?');">Hapus</a>
            </td>
            <td><img src="../img/<?php echo $row["gambar"]; ?>" width="70"></td>
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