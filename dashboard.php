<?php
session_start();
include "config/connection.php";
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit; // Ensure to exit after redirection
}

$queryWithoutFilter = "SELECT COUNT(id_record) AS total_data FROM record_anggota"; // Query to get total data without filter

// Execute query to get total data without filter
$resultTotalData = mysqli_query($koneksi, $queryWithoutFilter);
$rowTotalData = mysqli_fetch_assoc($resultTotalData);
$totalData = $rowTotalData['total_data'];

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

// Menghitung persentase masing-masing data
$percentages = [];
foreach ($dataCountTim as $count) {
    $percentage = round(($count / $totalData) * 100, 2);
    $percentages[] = $percentage;
}

// Contoh data grafik dengan persentase dan tanda persentase
$chartData = [
    'labels' => $dataPerTim,
    'values' => $percentages // Gunakan persentase sebagai nilai untuk pie chart
];

// Tambahkan tanda persentase ke dalam label untuk ditampilkan di chart
$chartData['labels'] = array_map(function ($label, $percentage) {
    return "$label ($percentage%)";
}, $chartData['labels'], $chartData['values']);
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
                                <div>
                                    <h2>Jumlah Anggota Berdasarkan Tim</h2>
                                    <div class="col-md-3">
                                        <img width="400" src="https://quickchart.io/chart?c=<?php echo urlencode(json_encode([
                                                                                                'type' => 'doughnut',
                                                                                                'data' => [
                                                                                                    'labels' => $chartData['labels'],
                                                                                                    'datasets' => [[
                                                                                                        'data' => $chartData['values'],
                                                                                                        'backgroundColor' => [
                                                                                                            'rgba(75, 192, 192, 0.2)',
                                                                                                            'rgba(255, 205, 86, 0.2)',
                                                                                                            'rgba(54, 162, 235, 0.2)'
                                                                                                            // Add more background colors for additional data points
                                                                                                        ],
                                                                                                        'borderColor' => [
                                                                                                            'rgba(75, 192, 192, 1)',
                                                                                                            'rgba(255, 205, 86, 1)',
                                                                                                            'rgba(54, 162, 235, 1)'
                                                                                                            // Add more border colors for additional data points
                                                                                                        ],
                                                                                                        'borderWidth' => 1
                                                                                                    ]]
                                                                                                ],
                                                                                                'options' => [
                                                                                                    'plugins' => [
                                                                                                        'legend' => [
                                                                                                            'display' => true,
                                                                                                            'position' => 'right'
                                                                                                        ],
                                                                                                        'labels' => [
                                                                                                            'render' => 'percentage',
                                                                                                            'precision' => 2,
                                                                                                            'fontSize' => 10,
                                                                                                            'fontColor' => '#000',
                                                                                                            'fontStyle' => 'bold'
                                                                                                        ],
                                                                                                        'doughnutlabel' => [
                                                                                                            'labels' => [
                                                                                                                [
                                                                                                                    'text' => $totalData,
                                                                                                                    'font' => [
                                                                                                                        'size' => 20,
                                                                                                                        'weight' => 'bold',
                                                                                                                    ],
                                                                                                                ],
                                                                                                                [
                                                                                                                    'text' => 'total anggota',
                                                                                                                ],
                                                                                                            ],
                                                                                                        ],
                                                                                                    ]
                                                                                                ]
                                                                                            ])); ?>" />
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table" id="data_detail">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kabupaten</th>
                                                <th>Kecamatan</th>
                                                <th>Desa</th>
                                                <th>TPS</th>
                                                <?php
                                                if ($_SESSION['username'] === "timpusat") {
                                                    $query = "SELECT record_anggota.username FROM record_anggota GROUP BY record_anggota.username";
                                                } else {
                                                    $query = "SELECT record_anggota.username FROM record_anggota WHERE record_anggota.username='" . $_SESSION['username'] . "' GROUP BY record_anggota.username";
                                                }
                                                $hasilQuery = mysqli_query($koneksi, $query);
                                                while ($peserta = mysqli_fetch_array($hasilQuery)) {
                                                ?>
                                                    <th><?php echo $peserta['username'] ?></th>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT 
                                            ra.id_record,
                                            ra.username,
                                            w1.nama AS nama_regency,
                                            w2.nama AS nama_kecamatan,
                                            w3.nama AS nama_desa,
                                            ra.id_tps,
                                            ra.full_name,
                                            ra.no_ktp,
                                            ra.phone_number,
                                            CASE 
                                                WHEN ra.jabatan = 0 THEN 'Koordinator Basis'
                                                WHEN ra.jabatan = 1 THEN 'Koordinator Desa'
                                                WHEN ra.jabatan = 2 THEN 'Koordinator Kecamatan'
                                                WHEN ra.jabatan = 3 THEN 'Koordinator TPS'
                                                WHEN ra.jabatan = 4 THEN 'Relawan'
                                            END jabatan,
                                            DATE(ra.created_time) c_date,
                                            ra.url_ktp,
                                            ra.url_diri
                                        FROM record_anggota ra
                                        INNER JOIN wilayah_2020 w1 ON ra.id_regency = w1.kode
                                        INNER JOIN wilayah_2020 w2 ON ra.id_kecamatan = w2.kode
                                        INNER JOIN wilayah_2020 w3 ON ra.id_desa = w3.kode
                                        WHERE LEFT(w1.kode, 2) = '32' AND CHAR_LENGTH(w1.kode) = 5 AND RIGHT(w1.kode, 2) IN ($allowedCodesStr)";

                                            // Membangun kondisi query berdasarkan filter
                                            if ($_SESSION['username'] !== "timpusat") {
                                                $query .= " AND username='" . $_SESSION['username'] . "'";
                                            }

                                            $data = mysqli_query($koneksi, $query);
                                            $no = 1;
                                            while ($d = mysqli_fetch_array($data)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $d['nama_regency']; ?></td>
                                                    <td><?php echo $d['nama_kecamatan']; ?></td>
                                                    <td><?php echo $d['nama_desa']; ?></td>
                                                    <td><?php echo ("TPS " . substr($d['id_tps'], strrpos($d['id_tps'], '.') + 1)); ?></td>
                                                    <?php
                                                    if ($_SESSION['username'] === "timpusat") {
                                                        $query = "SELECT record_anggota.username FROM record_anggota GROUP BY record_anggota.username";
                                                    } else {
                                                        $query = "SELECT record_anggota.username FROM record_anggota WHERE record_anggota.username='" . $_SESSION['username'] . "' GROUP BY record_anggota.username";
                                                    }
                                                    $hasilQuery = mysqli_query($koneksi, $query);
                                                    while ($peserta = mysqli_fetch_array($hasilQuery)) {
                                                    ?>
                                                        <td>
                                                            <input disabled type="checkbox" name="record_id[]" value="<?php echo $d['username']; ?>" <?php echo ($d['username'] === $peserta['username']) ? 'checked' : ''; ?>>
                                                        </td>
                                                    <?php
                                                    }
                                                    ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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