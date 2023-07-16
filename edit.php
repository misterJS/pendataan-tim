<?php

session_start();
include "config/connection.php";
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$id = $_GET['id']; // ID data yang akan diedit

$query = "SELECT * FROM record_anggota WHERE id_record = '$id'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sadulur Kang Imam">
    <meta name="keywords" content="Sadulur Kang Imam">
    <meta name="author" content="Sadulur Kang Imam">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Sadulur Kang Imam - Tim Pemenangan</title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Start css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- End css -->
</head>

<body class="vertical-layout">
    <!-- Start Containerbar -->
    <div id="containerbar" class="containerbar authenticate-bg">
        <div class="container">
            <div class="auth-box login-box">
                <div class="row no-gutters align-items-center justify-content-center">
                    <div class="col-md-6 col-lg-5">
                        <div class="auth-box-right">
                            <div class="card">
                                <div class="card-body">
                                    <form action="config/proses_edit.php" method="post" enctype="multipart/form-data">
                                        <div class="form-head">
                                            <a href="index.html" class="logo"><img src="assets/images/logo.png" class="img-fluid" alt="logo" /></a>
                                        </div>
                                        <h4 class="text-primary my-4">Form Edit Tim Pemenangan</h4>
                                        <br>
                                        <?php
                                        if (isset($_GET['alert'])) {
                                            if ($_GET['alert'] == 'gagal') {
                                        ?>
                                                <div class="alert alert-warning alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <h4><i class="icon fa fa-warning"></i> Peringatan !</h4>
                                                    Gagal Disimpan
                                                    <p><?php echo $_GET['error'] ?></p>
                                                </div>
                                            <?php
                                            } elseif ($_GET['alert'] == "berhasil") {
                                            ?>
                                                <div class="alert alert-success alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <h4><i class="icon fa fa-check"></i> Success</h4>
                                                    Berhasil Disimpan
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <input type="hidden" class="form-control" name="id" value=<?php echo $data['id_record']; ?>>
                                        <input type="hidden" class="form-control" name="username" value=<?php echo $_SESSION['username']; ?>>
                                        <div class="col-sm-12">
                                            <select name="id_regency" id="form_kab" class="form-control">
                                                <option value="">Pilih Kota/Kabupaten</option>
                                                <?php
                                                $daerah = mysqli_query($koneksi, "SELECT kode,nama FROM wilayah_2020 WHERE CHAR_LENGTH(kode)=2 ORDER BY nama");
                                                while ($d = mysqli_fetch_array($daerah)) {
                                                    $selected = ($data['id_regency'] == $d['kode']) ? 'selected' : '';
                                                ?>
                                                    <option value="<?php echo $d['kode']; ?>" <?php echo $selected; ?>><?php echo $d['nama']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <br />
                                        <div class="col-sm-12">
                                            <select name="id_kecamatan" id="form_kec" class="form-control">
                                                <option value="">Pilih Kecamatan</option>
                                                <?php
                                                $daerah = mysqli_query($koneksi, "SELECT kode,nama FROM wilayah_2020 WHERE CHAR_LENGTH(kode)=5 AND LEFT(kode,'5')='" . $data['id_regency'] . "' ORDER BY nama");

                                                while ($d = mysqli_fetch_array($daerah)) {
                                                    $selected = ($data['id_kecamatan'] == $d['kode']) ? 'selected' : '';
                                                ?>
                                                    <option value="<?php echo $d['kode']; ?>" <?php echo $selected; ?>><?php echo $d['nama']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="col-sm-12">
                                            <select name="id_desa" id="form_des" class="form-control">
                                                <option value="">Pilih Desa</option>
                                                <?php
                                                $daerah = mysqli_query($koneksi, "SELECT kode,nama FROM wilayah_2020 WHERE CHAR_LENGTH(kode)=10 AND LEFT(kode,'10')='" . $data['id_kecamatan'] . "' ORDER BY nama");

                                                while ($d = mysqli_fetch_array($daerah)) {
                                                    $selected = ($data['id_desa'] == $d['kode']) ? 'selected' : '';
                                                ?>
                                                    <option value="<?php echo $d['kode']; ?>" <?php echo $selected; ?>><?php echo $d['nama']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="col-sm-12">
                                            <select name="id_tps" id="form_tps" class="form-control">
                                                <option value="">Pilih TPS</option>
                                                <?php
                                                $daerah = mysqli_query($koneksi, "SELECT id_tps, CAST(SUBSTRING(id_tps, 15, 17) AS UNSIGNED) as tps_code FROM tps WHERE id_village='32." . $data['id_desa'] . "' ORDER BY tps_code ASC");
                                                while ($d = mysqli_fetch_array($daerah)) {
                                                    $selected = ($data['id_tps'] == $d['id_tps']) ? 'selected' : '';
                                                ?>
                                                    <option value="<?php echo $d['id_tps']; ?>" <?php echo $selected; ?>>TPS <?php echo $d['tps_code']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="col-sm-12">
                                            <input type="text" value="<?php echo $data['full_name']; ?>" class="form-control" name="full_name" placeholder="Isi nama lengkap" required />
                                        </div>
                                        <br>
                                        <div class="col-sm-12">
                                            <input type="text" value="<?php echo $data['no_ktp']; ?>" class="form-control" name="ktp" placeholder="Isi nomor KTP/NIK" minlength="16" maxlength="16" />
                                        </div>
                                        <br>
                                        <div class="col-sm-12">
                                            <input type="text" value="<?php echo $data['phone_number']; ?>" class="form-control" name="phone_number" placeholder="Isi nomor telepon" />
                                        </div>
                                        <br>
                                        <div class="col-sm-12">
                                            <select name="jabatan" class="form-control">
                                                <option value="0" <?php echo ($data['jabatan'] == '0') ? 'selected' : ''; ?>>Koordinator Basis</option>
                                                <option value="1" <?php echo ($data['jabatan'] == '1') ? 'selected' : ''; ?>>Koordinator Desa</option>
                                                <option value="2" <?php echo ($data['jabatan'] == '2') ? 'selected' : ''; ?>>Koordinator Kecamatan</option>
                                                <option value="3" <?php echo ($data['jabatan'] == '3') ? 'selected' : ''; ?>>Koordinator TPS</option>
                                                <option value="4" <?php echo ($data['jabatan'] == '4') ? 'selected' : ''; ?>>Relawan</option>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Foto KTP</label>
                                            <div class="col-sm-8">
                                                <?php if ($data['url_ktp']) : ?>
                                                    <img src="images/<?php echo $data['url_ktp']; ?>" alt="Foto KTP" width="200" id="foto_ktp_preview">
                                                <?php else : ?>
                                                    <p>Tidak ada foto KTP yang tersedia</p>
                                                <?php endif; ?>
                                                <input type="file" name="foto_ktp" id="form_foto_ktp">
                                                <p style="color: red">Upload foto atau ambil dari kamera</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Foto Diri</label>
                                            <div class="col-sm-8">
                                                <?php if ($data['url_diri']) : ?>
                                                    <img src="images/<?php echo $data['url_diri']; ?>" alt="Foto Diri" width="200" id="foto_diri_preview">
                                                <?php else : ?>
                                                    <p>Tidak ada foto diri yang tersedia</p>
                                                <?php endif; ?>
                                                <input type="file" name="foto_diri" id="form_foto_diri">
                                                <p style="color: red">Upload foto atau ambil dari kamera</p>
                                            </div>
                                        </div>
                                        <input type="submit" class="btn btn-success btn-lg btn-block font-18" name="submit" value="Edit">
                                        <button type="submit" onclick="window.location.href = 'landing.php';" class="btn btn-danger btn-lg btn-block font-18">Kembali ke Menu</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- End Containerbar -->
    <!-- Start js -->
    <script type="text/javascript">
        $(document).ready(function() {

            // sembunyikan form kecamatan, desa, dan tps
            // $("#form_kec").hide();
            // $("#form_des").hide();
            // $("#form_tps").hide();

            $('#form_foto_ktp').change(function(e) {
                var file = e.target.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#foto_ktp_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            });

            // Tampilkan preview foto diri setelah memilih gambar baru
            $('#form_foto_diri').change(function(e) {
                var file = e.target.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#foto_diri_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            });

            // ambil data kecamatan ketika data memilih kabupaten
            $('body').on("change", "#form_kab", function() {
                var id = $(this).val();
                var data = "id=" + id + "&data=kecamatan";
                console.log(id);
                $.ajax({
                    type: 'POST',
                    url: "get_daerah.php",
                    data: data,
                    success: function(hasil) {
                        $("#form_kec").html(hasil);
                    }
                });
            });

            // ambil data desa ketika data memilih kecamatan
            $('body').on("change", "#form_kec", function() {
                var id = $(this).val();
                var data = "id=" + id + "&data=desa";
                console.log(id);
                $.ajax({
                    type: 'POST',
                    url: "get_daerah.php",
                    data: data,
                    success: function(hasil) {
                        $("#form_des").html(hasil);

                    }
                });
            });

            // ambil data tps ketika data memilih desa
            $('body').on("change", "#form_des", function() {
                var id = $(this).val();
                var data = "id=" + id + "&data=tps";
                console.log(id);
                $.ajax({
                    type: 'POST',
                    url: "get_daerah.php",
                    data: data,
                    success: function(hasil) {
                        $("#form_tps").html(hasil);
                    }
                });
            });

        });
    </script>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <!-- End js -->
</body>

</html>