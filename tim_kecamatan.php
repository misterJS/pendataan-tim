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
    <title>Sadulur Kang Imam</title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Start css -->
    <!-- Switchery css -->
    <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet">
    <link href="assets/plugins/footable/css/footable.bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/flag-icon.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- End css -->
</head>

<body class="horizontal-layout">
    <!-- Start Containerbar -->
    <div id="containerbar" class="container-fluid">
        <!-- Start Rightbar -->
        <div class="rightbar">
            <?php include("components/header_admin.php"); ?>
            <!-- Start Contentbar -->
            <div class="contentbar">
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="card-title">Jumlah Anggota per Kecamatan</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <select name="id_regency" id="form_kab" class="form-control">
                                            <option value="">Pilih Kabupaten</option>
                                            <?php
                                            $daerah = mysqli_query($koneksi, "SELECT kode,nama FROM wilayah_2020  WHERE CHAR_LENGTH(kode)=2 ORDER BY nama");
                                            while ($d = mysqli_fetch_array($daerah)) {
                                            ?>
                                                <option value="<?php echo $d['kode']; ?>"><?php echo $d['nama']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table foo-filtering-table" data-filtering="true" id="data_detail"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
            <!-- End Contentbar -->
            <!-- Start Footerbar -->
            <div class="footerbar">
                <footer class="footer">
                    <p class="mb-0">© 2023 Sadulur Kang Imam - All Rights Reserved.</p>
                </footer>
            </div>
            <!-- End Footerbar -->
        </div>
        <!-- End Rightbar -->
    </div>
    <!-- End Containerbar -->
    <script type="text/javascript">
        $(document).ready(function() {

            // ambil data detail ketika data memilih kabupaten
            $('body').on("change", "#form_kab", function() {
                var id = $(this).val();
                var data = "id=" + id + "&data=kecamatan";
                $.ajax({
                    type: 'POST',
                    url: "get_detail.php",
                    data: data,
                    success: function(hasil) {
                        $("#data_detail").html(hasil);
                        $("#data_detail").show();
                    }
                });
            });
        });
    </script>
    <!-- Start js -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/horizontal-menu.js"></script>
    <!-- Switchery js -->
    <script src="assets/plugins/switchery/switchery.min.js"></script>
    <!-- Footable js -->
    <script src="assets/plugins/moment/moment.js"></script>
    <script src="assets/plugins/footable/js/footable.min.js"></script>
    <script src="assets/js/custom/custom-table-footable.js"></script>
    <!-- Core js -->
    <script src="assets/js/core.js"></script>
    <!-- End js -->
</body>

</html>