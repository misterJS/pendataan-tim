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
                                    <?php 
                                    if(isset($_GET['pesan'])){
                                        if($_GET['pesan'] == "gagal"){
                                            echo "Login gagal! username dan password salah!";
                                        }else if($_GET['pesan'] == "logout"){
                                            echo "Anda telah berhasil logout";
                                        }else if($_GET['pesan'] == "belum_login"){
                                            echo "Anda harus login untuk mengakses halaman admin";
                                        }
                                    }
                                    ?>
                                    <div class="form-head">
                                        <a href="/" class="logo"><img src="assets/images/logo.png" class="img-fluid" alt="logo" /></a>
                                    </div>
                                    <h4 class="text-primary my-4">Menu</h4>
                                    <button type="submit" onclick="window.location.href = 'home.php';" class="btn btn-info btn-lg btn-block font-18">Formulir Pendataan</button>
                                    <button type="submit" onclick="window.location.href = 'detail_data.php';" class="btn btn-success btn-lg btn-block font-18" >Detail Data</button>    
                                    <button type="submit" onclick="window.location.href = 'config/logout.php';" class="btn btn-danger btn-lg btn-block font-18" >Logout</button>                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div >
        </div >
    <!-- End Containerbar -->
    <!-- Start js -->        
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <!-- End js -->
</body>
</html>