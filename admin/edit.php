<?php
session_start();

if(isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}

require '../koneksi/db.php';

$id = $_GET["id"];
$df = query("SELECT * FROM daftar where id=$id")[0];

if(isset($_POST["submit"])){

    if(edit($_POST) > 0){
        echo "
            <script> alert('data berhasil diubah');
            document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "<script> alert('data gagal diubah');
        document.location.href = 'index.php';
        </script>
        ";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit data</title>
</head>
<body>
    <h1>Edit Data Mahasiswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $df["id"]; ?> ">
        <input type="hidden" name="gambarLama" value="<?php echo $df["gambar"]; ?> ">
        <ul>
            <li>
                <label for="gambar"> Gambar : </label>
                <img src="img/<?= $df['gambar']; ?>" width="40"> <br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <label for="nama"> Nama : </label>
                <input type="text" name="nama" id="nama" value="<?php echo $df["nama"]; ?>">
            </li>
            <li>
                <label for="email"> Email : </label>
                <input type="text" name="email" id="email" value="<?php echo $df["email"]; ?>">
            </li>
            <li>
                <label for="tanggal_lahir"> tanggal lahir : </label>
                <input type="text" name="tanggal_lahir" id="tanggal_lahir" value="<?php echo $df["tanggal_lahir"]; ?>">
            </li>
            <li>
                <label for="umur"> umur : </label>
                <input type="text" name="umur" id="umur" value="<?php echo $df["umur"]; ?>">
            </li>
            <li>
                <label for="jenis_kelamin"> jenis kelamin : </label>
                <input type="text" name="jenis_kelamin" id="jenis_kelamin" value="<?php echo $df["jenis_kelamin"]; ?>">
            </li>
            <li>
                <label for="alamat"> Alamat : </label>
                <input type="text" name="alamat" id="alamat" value="<?php echo $df["alamat"]; ?>">
            </li>
            
            <li>
                <button type="submit" name="submit">Submit</button>
            </li>
        </ul>
    </form>
</body>
</html>