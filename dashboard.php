<?php
session_start();
include "config/connection.php";
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit; // Ensure to exit after redirection
}

$query = "SELECT wilayah_2020.nama, COUNT(record_anggota.id_record) AS jumlah, record_anggota.username FROM record_anggota";

$id_regency = isset($_GET['id_regency']) ? $_GET['id_regency'] : '';
$id_kecamatan = isset($_GET['id_kecamatan']) ? $_GET['id_kecamatan'] : '';
$id_desa = isset($_GET['id_desa']) ? $_GET['id_desa'] : '';
$id_tps = isset($_GET['id_tps']) ? $_GET['id_tps'] : '';

// Membangun kondisi query berdasarkan filter
if ($_SESSION['username'] !== "timpusat") {
    if (!empty($id_regency)) {
        $query .= " JOIN wilayah_2020 ON wilayah_2020.kode = record_anggota.id_kecamatan WHERE username='" . $_SESSION['username'] . "' AND id_regency = '$id_regency' ";
        if (!empty($id_kecamatan)) {
            $query .= " AND id_kecamatan = '$id_kecamatan' ";
            if (!empty($id_desa)) {
                $query .= " AND id_desa = '$id_desa' ";
                if (!empty($id_tps)) {
                    $query .= " AND id_tps = '$id_tps' ";
                }
            }
        }
    } else {
        $query .= " JOIN wilayah_2020 ON wilayah_2020.kode = record_anggota.id_kecamatan WHERE username='" . $_SESSION['username'] . "'";
    }
} else {
    if (!empty($id_regency)) {
        $query .= " JOIN wilayah_2020 ON wilayah_2020.kode = record_anggota.id_kecamatan WHERE id_regency = '$id_regency' ";
        if (!empty($id_kecamatan)) {
            $query .= " AND id_kecamatan = '$id_kecamatan' ";
            if (!empty($id_desa)) {
                $query .= " AND id_desa = '$id_desa' ";
                if (!empty($id_tps)) {
                    $query .= " AND id_tps = '$id_tps' ";
                }
            }
        }
    } else {
        $query .= " JOIN wilayah_2020 ON wilayah_2020.kode = record_anggota.id_kecamatan";
    }
}

$query .= " GROUP BY wilayah_2020.nama";

$result = mysqli_query($koneksi, $query);

$dataPerTim = [];
$dataCountTim = [];
while ($row = mysqli_fetch_array($result)) {
    $dataPerTim[] = $row['nama']; // Use 'nama' instead of 'username'
    $dataCountTim[] = $row['jumlah'];
}

// Contoh data grafik
$chartData = [
    'labels' => $dataPerTim,
    'values' => $dataCountTim
];
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
    <script src="assets/plugins/footable/js/footable.min.js"></script>
    <script src="assets/js/custom/custom-table-footable.js"></script>
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
                                <h5 class="card-title">Dashboard</h5>
                            </div>
                            <div class="card-body">
                                <form action="dashboard.php" method="get" class='form-row'>
                                    <div class="form-group col-md-2">
                                        <select name="id_regency" id="form_kab" class="form-control">
                                            <option value="">Pilih Kabupaten</option>
                                            <?php
                                            $allowedCodes = array('07', '08', '79', '18');
                                            $allowedCodesStr = "'" . implode("','", $allowedCodes) . "'";

                                            $daerah = mysqli_query($koneksi, "SELECT kode, nama FROM wilayah_2020 WHERE LEFT(kode, 2) = '32' AND CHAR_LENGTH(kode) = 5 AND RIGHT(kode, 2) IN ($allowedCodesStr) ORDER BY nama");

                                            while ($d = mysqli_fetch_array($daerah)) {
                                            ?>
                                                <option value="<?php echo $d['kode']; ?>"><?php echo $d['nama']; ?></option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <select name="id_kecamatan" id="form_kec" class="form-control">
                                            <option value="">Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select name="id_desa" id="form_des" class="form-control">
                                            <option value="">Pilih Desa</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select name="id_tps" id="form_tps" class="form-control">
                                            <option value="">Pilih TPS</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <input type="submit" value="Cari" class="btn btn-success btn-lg btn-block font-14">
                                    </div>
                                </form>
                                <div class="container">
                                    <h2>Jumlah Anggota Berdasarkan Tim</h2>
                                    <div class="col-md-6">
                                        <canvas id="chartPerTim"></canvas>
                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data grafik (contoh data)
        var data = <?php echo json_encode($chartData); ?>;

        // Membuat grafik jika ada data yang valid
        if (data && data.labels && data.values) {
            var ctx = document.getElementById('chartPerTim').getContext('2d');
            var chartPerTim = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Data',
                        data: data.values,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            // Tambahkan warna latar belakang lainnya sesuai dengan jumlah data
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(54, 162, 235, 1)',
                            // Tambahkan warna batas lainnya sesuai dengan jumlah data
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
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
    <!-- Core js -->
    <script src="assets/js/core.js"></script>
    <!-- End js -->
    <script type="text/javascript">
        $(document).ready(function() {
            // ambil data kecamatan/kota ketika data memilih kabupaten
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

            // ambil data desa ketika data memilih kecamatan/kota
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
</body>

</html>