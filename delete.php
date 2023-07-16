<?php
include 'config/connection.php';

$id = $_POST['id']; // ID data yang akan dihapus

$query = "DELETE FROM record_anggota WHERE id_record='$id'";

if (mysqli_query($koneksi, $query)) {
    echo 'success';
} else {
    echo 'error';
}

mysqli_close($koneksi);
?>
