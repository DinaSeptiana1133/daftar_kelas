<?php
//koneksi ke DB
$conn = mysqli_connect("localhost", "root", "", "daftar_kelas");

function query($query){
    global $conn;
    
// ambil data dari tabel mahasiswa
$result = mysqli_query($conn, $query);
$rows = [];
while($row = mysqli_fetch_assoc($result)){
    $rows[] = $row;
}
return $rows;
}

function edit($data){
    global $conn;

    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $tanggal_lahir = htmlspecialchars($data["tanggal_lahir"]);
    $umur = htmlspecialchars($data["umur"]);
    $jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // cek apakah user pilih gambar baru atau tidak
    if($_FILES['gambar']['error'] === 4 ){
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    // query insert data
    $query = "UPDATE daftar SET
                nama = '$nama',
                email = '$email',
                alamat = '$alamat',
                tanggal_lahir = '$tanggal_lahir',
                umur = '$umur',
                jenis_kelamin = '$jenis_kelamin',
                gambar = '$gambar'
                 where id=$id
                ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function tambah($data){
    global $conn;
    // ambil data dari setiap elemen form
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $tanggal_lahir = htmlspecialchars($data["tanggal_lahir"]);
    $umur = htmlspecialchars($data["umur"]);
    $jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
    
    // upload gambar
    $gambar = upload();
    if(!$gambar){
        return false;
    }

    // query insert data
    $query = "INSERT INTO daftar VALUES ('','$nama','$email','$alamat','$tanggal_lahir','$umur','$jenis_kelamin')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload(){
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if($error === 4){
        echo "<script> alert ('Pilih gambar terlebih dahulu');
        </script>";
        return false;
    }

    // cek apakah yang diupload adalah gambar atau bukan
    $ekstensiGambarValid = ['jpg','jpeg','png'];
    $ekstensiGambar = explode('.',$namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
        echo "<script> alert ('Yang anda upload bukan gambar');
        </script>";
        return false;
    }

    // cek jika ukuran terlalu besar
    if($ukuranFile > 1000000){
        echo "<script> alert ('Ukuran gambar terlalu besar');
        </script>";
        return false;
    }

    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;


    move_uploaded_file($tmpName, 'img/'.$namaFileBaru);
    return $namaFileBaru;
}

function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM daftar WHERE id = $id");
    return mysqli_affected_rows($conn);
}