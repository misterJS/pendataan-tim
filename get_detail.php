<?php
include "config/connection.php";

$data = $_POST['data'];
$id = $_POST['id'];
?>
<?php
if ($data == "idx") {
?>
    <thead>
        <tr>
            <th data-breakpoints="xs">#</th>
            <th>Tim</th>
            <th>Jabatan</th>
            <th>Nama Lengkap</th>
            <th>NIK</th>
            <th>Nomor Ponsel</th>
            <th>Tanggal Pendaftaran</th>
            <th>Foto KTP</th>
            <th>Foto Diri</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = mysqli_query($koneksi, "SELECT 
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
		FROM record_anggota WHERE id_tps='$id'");
        $no = 1;
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['username']; ?></td>
                <td><?php echo $d['jabatan']; ?></td>
                <td><?php echo $d['full_name']; ?></td>
                <td><?php echo $d['no_ktp']; ?></td>
                <td><?php echo $d['phone_number']; ?></td>
                <td><?php echo $d['c_date']; ?></td>
                <td><img src="images/<?php echo $d['url_ktp'] ?>" width="35" height="40"></td>
                <td><img src="images/<?php echo $d['url_diri'] ?>" width="35" height="40"></td>
            </tr>
        <?php }    ?>
    </tbody>

<?php

} else if ($data == "kecamatan") {
?>
    <thead>
        <tr>
            <th data-breakpoints="xs">#</th>
            <th>Nama Kecamatan</th>
            <th>Nama Koordinator</th>
            <th>Jumlah Anggota</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = mysqli_query($koneksi, "select nama, COUNT(record_anggota.id_record) AS jumlah, username from record_anggota
            join wilayah_2020 on wilayah_2020.kode = record_anggota.id_kecamatan where id_regency='$id' GROUP BY wilayah_2020.nama;");
        $no = 1;
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['nama']; ?></td>
                <td><?php echo $d['username']; ?></td>
                <td><?php echo $d['jumlah']; ?></td>
            </tr>
        <?php }    ?>
    </tbody>
<?php

} else if ($data == "desa") {
?>
    <thead>
        <tr>
            <th data-breakpoints="xs">#</th>
            <th>Nama Desa</th>
            <th>Nama Koordinator</th>
            <th>Jumlah Anggota</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = mysqli_query($koneksi, "select nama, count(id_record) as jumlah, username from record_anggota
            join wilayah_2020 on wilayah_2020.kode = record_anggota.id_desa where id_kecamatan='$id' GROUP BY wilayah_2020.nama;");
        $no = 1;
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['nama']; ?></td>
                <td><?php echo $d['username']; ?></td>
                <td><?php echo $d['jumlah']; ?></td>
            </tr>
        <?php }    ?>
    </tbody>
<?php
} else if ($data == "tps") {
?>
    <thead>
        <tr>
            <th data-breakpoints="xs">#</th>
            <th>Nama TPS</th>
            <th>Nama Koordinator</th>
            <th>Jumlah Anggota</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = mysqli_query($koneksi, "select id_tps, count(id_tps) as jumlah, username from record_anggota where id_desa='$id' GROUP BY id_tps;");
        $no = 1;
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo ("TPS " . substr($d['id_tps'], strrpos($d['id_tps'], '.') + 1)); ?></td>
                <td><?php echo $d['username']; ?></td>
                <td><?php echo $d['jumlah']; ?></td>
            </tr>
        <?php }    ?>
    </tbody>
<?php
}

?>