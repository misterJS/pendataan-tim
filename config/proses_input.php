<?php 
include 'connection.php';
$username=$_POST['username'];
$id_regency = $_POST['id_regency'];
$id_kecamatan = $_POST['id_kecamatan'];
$id_desa = $_POST['id_desa'];
$id_tps = $_POST['id_tps'];
$full_name = $_POST['full_name'];
$no_ktp = $_POST['ktp'];
$phone_number = $_POST['phone_number'];
$jabatan = $_POST['jabatan'];

// ambil file foto ktp
$rand = rand();
$ekstensi =  array('png','jpg','jpeg','gif');
$filename_ktp = $_FILES['foto_ktp']['name'];
$ukuran_ktp = $_FILES['foto_ktp']['size'];
$ext_ktp = pathinfo($filename_ktp, PATHINFO_EXTENSION);
 
// ambil file foto diri
$rand2 = rand();
$filename_diri = $_FILES['foto_diri']['name'];
$ukuran_diri = $_FILES['foto_diri']['size'];
$ext_diri = pathinfo($filename_diri, PATHINFO_EXTENSION);

// cek unik ktp
if (!is_numeric($no_ktp)) {
    header("location:../home.php?alert=gagal&error=Nomor KTP/NIK harus berupa angka");
    exit;
}

$query = "SELECT COUNT(*) FROM record_anggota WHERE no_ktp = '$no_ktp'";
$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_array($result);

if ($row[0] > 0) {
    header("location:../home.php?alert=gagal&error=Nomor KTP/NIK sudah ada dalam basis data");
    exit;
}

$url_ktp = $rand.'_'.$filename_ktp;
$url_diri = $rand2.'_'.$filename_diri;

if($url_ktp && $url_diri){
    move_uploaded_file($_FILES['foto_ktp']['tmp_name'], '../images/'.$rand.'_'.$filename_ktp);
    move_uploaded_file($_FILES['foto_diri']['tmp_name'], '../images/'.$rand2.'_'.$filename_diri);
    mysqli_query($koneksi, "INSERT INTO record_anggota VALUES(NULL,'$username','$id_regency','$id_kecamatan','$id_desa','$id_tps','$full_name','$no_ktp','$phone_number','$jabatan','$url_ktp', '$url_diri', NOW(), 1)");
    header("location:../home.php?alert=berhasil");
}
else {
    header("location:../home.php?alert=gagal");
}
?>