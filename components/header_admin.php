<style>
    @media (max-width: 768px) {
        .horizontal-menu {
            margin-top: 33px !important;
        }
    }
</style>

<!-- Start Topbar Mobile -->
<div class="topbar-mobile">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="mobile-logobar">
                <a href="landing.php" class="mobile-logo"><img src="assets/images/logo.png" class="img-fluid" alt="logo"></a>
            </div>
            <div class="mobile-togglebar">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <div class="topbar-toggle-icon">
                            <a class="topbar-toggle-hamburger" href="javascript:void();">
                                <img src="assets/images/svg-icon/horizontal.svg" class="img-fluid menu-hamburger-horizontal" alt="horizontal">
                                <img src="assets/images/svg-icon/verticle.svg" class="img-fluid menu-hamburger-vertical" alt="verticle">
                            </a>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="menubar">
                            <a class="menu-hamburger navbar-toggle bg-transparent" href="javascript:void();" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="true">
                                <img src="assets/images/svg-icon/collapse.svg" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                <img src="assets/images/svg-icon/close.svg" class="img-fluid menu-hamburger-close" alt="close">
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Start Topbar -->
<div class="topbar">
    <!-- Start container-fluid -->
    <div class="container-fluid">
        <!-- Start row -->
        <div class="row align-items-center">
            <!-- Start col -->
            <div class="col-md-12 align-self-center">
                <div class="togglebar">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <div class="logobar">
                                <!-- <a href="index.html" class="logo logo-large"><img src="assets/images/logo.svg" class="img-fluid" alt="logo"></a> -->
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End container-fluid -->
</div>
<!-- End Topbar -->
<!-- Start Navigationbar -->
<div class="navigationbar">
    <!-- Start container-fluid -->
    <div class="container-fluid">
        <!-- Start Horizontal Nav -->
        <nav class="horizontal-nav mobile-navbar fixed-navbar">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="horizontal-menu">
                    <li class="scroll"><a href="dashboard.php"><img src="assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="dashboard"><span>Dashboard</span></a></li>
                    <li class="scroll"><a href="detail_data.php"><img src="assets/images/svg-icon/widgets.svg" class="img-fluid" alt="widgets"><span>Detail Data</span></a></li>
                    <li class="dropdown">
                        <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="assets/images/svg-icon/apps.svg" class="img-fluid" alt="apps"><span>Data Tim</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="tim_kecamatan.php">Kecamatan</a></li>
                            <li><a href="tim_desa.php">Desa</a></li>
                            <li><a href="tim_tps.php"></i>TPS</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End Horizontal Nav -->
    </div>
    <!-- End container-fluid -->
</div>
<!-- End Navigationbar -->
<!-- Start Breadcrumbbar -->
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Data Internal</h4>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <button class="btn btn-danger" onclick="window.location.href = 'landing.php';">Kembali ke Menu</button>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbbar -->