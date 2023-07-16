<?php

if(isset($_GET['id_regency']) AND isset($_GET['id_kecamatan']) AND isset($_GET['id_desa']) AND empty(isset($_GET['id_desa'])) ){
    $cari = $_GET['id_kecamatan'];
    echo("SELECT 
    username,
    full_name,
    no_ktp,
    phone_number,
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
    FROM record_anggota WHERE id_tps='".$cari."'");		
}

?>