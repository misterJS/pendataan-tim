<?php
session_start();
include "config/connection.php";
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$id_regency = isset($_GET['id_regency']) ? $_GET['id_regency'] : '';
$id_kecamatan = isset($_GET['id_kecamatan']) ? $_GET['id_kecamatan'] : '';
$id_desa = isset($_GET['id_desa']) ? $_GET['id_desa'] : '';
$id_tps = isset($_GET['id_tps']) ? $_GET['id_tps'] : '';
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
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
                                <h5 class="card-title">Detail Data Tim</h5>
                            </div>
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
                            <div class="card-body">
                                <form action="detail_data.php" method="get" class='form-row'>
                                    <div class="form-group col-md-2">
                                        <select name="id_regency" id="form_kab" class="form-control">
                                            <option value="">Pilih Kabupaten</option>
                                            <?php
                                            $allowedCodes = array('07', '08', '79', '18');
                                            $allowedCodesStr = "'" . implode("','", $allowedCodes) . "'";

                                            $daerah = mysqli_query($koneksi, "SELECT kode, nama FROM wilayah_2020 WHERE LEFT(kode, 2) = '32' AND CHAR_LENGTH(kode) = 5 AND RIGHT(kode, 2) IN ($allowedCodesStr) ORDER BY nama");

                                            while ($d = mysqli_fetch_array($daerah)) {
                                                $selected = ($d['kode'] == $id_regency) ? 'selected' : ''; // Add this line to mark the correct option as selected
                                            ?>
                                                <option value="<?php echo $d['kode']; ?>" <?php echo $selected; ?>><?php echo $d['nama']; ?></option>
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
                                    <div class="form-group col-md-1">
                                        <input type="submit" value="Cari" class="btn btn-success btn-lg btn-block font-14">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <a href="export_excel.php?id_regency=<?php echo $id_regency; ?>&id_kecamatan=<?php echo $id_kecamatan; ?>&id_desa=<?php echo $id_desa; ?>&id_tps=<?php echo $id_tps; ?>" class="btn btn-info btn-lg btn-block font-14">Export to Excel</a>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table" id="data_detail">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tim</th>
                                                <th>Jabatan</th>
                                                <th>Nama Lengkap</th>
                                                <th>Nomor Ponsel</th>
                                                <th>Kabupaten</th>
                                                <th>Kecamatan</th>
                                                <th>Desa</th>
                                                <th>Tps</th>
                                                <th>Foto KTP</th>
                                                <th>Foto Diri</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT 
                                                id_record,
                                                username,
                                                full_name,
                                                no_ktp,
                                                phone_number,
                                                id_regency,
                                                id_kecamatan,
                                                id_desa,
                                                id_tps,
                                                CASE 
                                                    WHEN jabatan = 0 THEN 'Koordinator Basis'
                                                    WHEN jabatan = 1 THEN 'Koordinator Desa'
                                                    WHEN jabatan = 2 THEN 'Koordinator Kecamatan'
                                                    WHEN jabatan = 3 THEN 'Koordinator TPS'
                                                    WHEN jabatan = 4 THEN 'Relawan'
                                                END jabatan,
                                                DATE(created_time) c_date,
                                                url_ktp,
                                                url_diri
                                            FROM record_anggota";

                                            $id_regency = isset($_GET['id_regency']) ? $_GET['id_regency'] : '';
                                            $id_kecamatan = isset($_GET['id_kecamatan']) ? $_GET['id_kecamatan'] : '';
                                            $id_desa = isset($_GET['id_desa']) ? $_GET['id_desa'] : '';
                                            $id_tps = isset($_GET['id_tps']) ? $_GET['id_tps'] : '';

                                            // Membangun kondisi query berdasarkan filter
                                            if ($_SESSION['username'] === "timpusat") {
                                                if (!empty($id_regency)) {
                                                    $query .= " WHERE id_regency = '$id_regency' ";
                                                    if (!empty($id_kecamatan)) {
                                                        $query .= " AND id_kecamatan = '$id_kecamatan' ";
                                                        if (!empty($id_desa)) {
                                                            $query .= " AND id_desa = '$id_desa' ";
                                                            if (!empty($id_tps)) {
                                                                $query .= " AND id_tps = '$id_tps' ";
                                                            }
                                                        }
                                                    }
                                                }
                                            } else {
                                                if (!empty($id_regency)) {
                                                    $query .= " WHERE username='" . $_SESSION['username'] . "' AND id_regency = '$id_regency' ";
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
                                                    $query .= " WHERE username='" . $_SESSION['username'] . "'";
                                                }
                                            }

                                            $data = mysqli_query($koneksi, $query);
                                            $no = 1;
                                            while ($d = mysqli_fetch_array($data)) {

                                                $regency_query = "SELECT nama FROM wilayah_2020 WHERE kode = '{$d['id_regency']}'";
                                                $regency_result = mysqli_query($koneksi, $regency_query);
                                                $regency_row = mysqli_fetch_assoc($regency_result);
                                                $regency_name = $regency_row['nama'];

                                                $kecamatan_query = "SELECT nama FROM wilayah_2020 WHERE kode = '{$d['id_kecamatan']}'";
                                                $kecamatan_result = mysqli_query($koneksi, $kecamatan_query);
                                                $kecamatan_row = mysqli_fetch_assoc($kecamatan_result);
                                                $kecamatan_name = $kecamatan_row['nama'];

                                                $desa_query = "SELECT nama FROM wilayah_2020 WHERE kode = '{$d['id_desa']}'";
                                                $desa_result = mysqli_query($koneksi, $desa_query);
                                                $desa_row = mysqli_fetch_assoc($desa_result);
                                                $desa_name = $desa_row['nama'];

                                                $id_tps_substring = substr($d['id_tps'], 15, 17);

                                            ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $d['username']; ?></td>
                                                    <td><?php echo $d['jabatan']; ?></td>
                                                    <td><?php echo $d['full_name']; ?></td>
                                                    <td><?php echo $d['phone_number']; ?></td>
                                                    <td><?php echo $regency_name; ?></td>
                                                    <td><?php echo $kecamatan_name; ?></td>
                                                    <td><?php echo $desa_name; ?></td>
                                                    <td>TPS-<?php echo $id_tps_substring; ?></td>
                                                    <td><img src="images/<?php echo $d['url_ktp'] ?>" width="35" height="40"></td>
                                                    <td><img src="images/<?php echo $d['url_diri'] ?>" width="35" height="40"></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="edit.php?id=<?php echo $d['id_record'] ?>">
                                                                <button class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                    Edit
                                                                </button>
                                                            </a>
                                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" onclick="confirmDelete(<?php echo $d['id_record']; ?>)">
                                                                Delete
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
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

            // Get URL parameters and set selected value for the select elements
            var urlParams = new URLSearchParams(window.location.search);
            var id_regency = urlParams.get('id_regency');
            var id_kecamatan = urlParams.get('id_kecamatan');
            var id_desa = urlParams.get('id_desa');
            var id_tps = urlParams.get('id_tps');

            // Set selected value on select elements based on URL parameters
            if (id_regency) {
                $("#form_kab").val(id_regency);
            }

            if (id_kecamatan) {
                $("#form_kec").val(id_kecamatan);
            }

            if (id_desa) {
                $("#form_des").val(id_desa);
            }

            if (id_tps) {
                $("#form_tps").val(id_tps);
            }

            $('#data_detail').DataTable();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#data_detail').DataTable();
        });

        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                // Redirect to delete process
                $.ajax({
                    url: 'delete.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        // Handle the response
                        if (response == 'success') {
                            alert('Data berhasil dihapus');
                            location.reload();
                        } else {
                            alert('Gagal menghapus data');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan dalam menghapus data');
                    }
                });
            }
        }
    </script>
</body>

</html>