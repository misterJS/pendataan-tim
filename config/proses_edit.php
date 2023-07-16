<?php
include 'connection.php';

$id = $_POST['id']; // ID data yang akan diedit
$id_regency = $_POST['id_regency'];
$id_kecamatan = $_POST['id_kecamatan'];
$id_desa = $_POST['id_desa'];
$id_tps = $_POST['id_tps'];
$full_name = $_POST['full_name'];
$no_ktp = $_POST['ktp'];
$phone_number = $_POST['phone_number'];
$jabatan = $_POST['jabatan'];

// Cek apakah ada file foto ktp yang diunggah
if ($_FILES['foto_ktp']['name']) {
    // ambil file foto ktp
    $filename_ktp = $_FILES['foto_ktp']['name'];
    $ukuran_ktp = $_FILES['foto_ktp']['size'];
    $ext_ktp = pathinfo($filename_ktp, PATHINFO_EXTENSION);

    $rand = rand();
    $url_ktp = $rand . '_' . $filename_ktp;
    move_uploaded_file($_FILES['foto_ktp']['tmp_name'], '../images/' . $rand . '_' . $filename_ktp);
} else {
    // Jika tidak ada perubahan pada foto ktp, gunakan URL foto KTP yang lama
    $query = "SELECT url_ktp FROM record_anggota WHERE id_record='$id'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
    $url_ktp = $data['url_ktp'];
}

// Cek apakah ada file foto diri yang diunggah
if ($_FILES['foto_diri']['name']) {
    // ambil file foto diri
    $filename_diri = $_FILES['foto_diri']['name'];
    $ukuran_diri = $_FILES['foto_diri']['size'];
    $ext_diri = pathinfo($filename_diri, PATHINFO_EXTENSION);

    $rand2 = rand();
    $url_diri = $rand2 . '_' . $filename_diri;
    move_uploaded_file($_FILES['foto_diri']['tmp_name'], '../images/' . $rand2 . '_' . $filename_diri);
} else {
    // Jika tidak ada perubahan pada foto diri, gunakan URL foto diri yang lama
    $query = "SELECT url_diri FROM record_anggota WHERE id_record='$id'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
    $url_diri = $data['url_diri'];
}

$query = "UPDATE record_anggota SET id_regency='$id_regency', id_kecamatan='$id_kecamatan', id_desa='$id_desa', id_tps='$id_tps', full_name='$full_name', no_ktp='$no_ktp', phone_number='$phone_number', jabatan='$jabatan', url_ktp='$url_ktp', url_diri='$url_diri' WHERE id_record='$id'";

if (mysqli_query($koneksi, $query)) {
    header("Location: ../detail_data.php?alert=berhasil");
} else {
    header("Location: ../detail_data.php?alert=gagal&error=" . mysqli_error($koneksi));
}

mysqli_close($koneksi);
?>
