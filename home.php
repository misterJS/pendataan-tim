<?php

session_start();
include "config/connection.php";
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

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
                                    <form action="config/proses_input.php" method="post" enctype="multipart/form-data">
                                        <div class="form-head">
                                            <a href="index.html" class="logo"><img src="assets/images/logo.png" class="img-fluid" alt="logo" /></a>
                                        </div>
                                        <h4 class="text-primary my-4">Form Pendaftaran Tim Pemenangan</h4>
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
                                        <input type="hidden" class="form-control" name="username" value=<?php echo $_SESSION['username']; ?>>
                                        <div class="col-sm-12">
                                            <select name="id_regency" id="form_kab" class="form-control">
                                                <option value="">Pilih Kota/Kabupaten</option>
                                                <?php
                                                $daerah = mysqli_query($koneksi, "SELECT kode,nama FROM wilayah_2020 WHERE CHAR_LENGTH(kode)=2 ORDER BY nama");
                                                while ($d = mysqli_fetch_array($daerah)) {
                                                ?>
                                                    <option value="<?php echo $d['kode']; ?>"><?php echo $d['nama']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <br />
                                        <div class="col-sm-12">
                                            <select name="id_kecamatan" id="form_kec" class="form-control">
                                                <option value="">Pilih Kecamatan</option>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="col-sm-12">
                                            <select name="id_desa" id="form_des" class="form-control">
                                                <option value="">Pilih Desa</option>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="col-sm-12">
                                            <select name="id_tps" id="form_tps" class="form-control">
                                                <option value="">Pilih TPS</option>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="full_name" placeholder="Isi nama lengkap" required />
                                        </div>
                                        <br>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="ktp" placeholder="Isi nomor KTP/NIK" minlength="16" maxlength="16" />
                                        </div>
                                        <br>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="phone_number" placeholder="Isi nomor telepon" />
                                        </div>
                                        <br>
                                        <div class="col-sm-12">
                                            <select name="jabatan" class="form-control">
                                                <option selected>Pilih Jabatan</option>
                                                <option value="0">Koordinator Basis</option>
                                                <option value="1">Koordinator Desa</option>
                                                <option value="2">Koordinator Kecamatan</option>
                                                <option value="3">Koordinator TPS</option>
                                                <option value="4">Relawan</option>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Foto KTP</label>
                                            <div class="col-sm-12">
                                                <input type="file" name="foto_ktp" required="required">
                                                <p style="color: red">Upload foto atau ambil dari kamera</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label">Foto Diri</label>
                                            <div class="col-sm-12">
                                                <input type="file" name="foto_diri" required="required">
                                                <p style="color: red">Upload foto atau ambil dari kamera</p>
                                            </div>
                                        </div>
                                        <input type="submit" class="btn btn-success btn-lg btn-block font-18" name="submit" value="Submit">
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