<?php
session_start();
include "config/connection.php";
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

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
        $query = "SELECT 
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
		FROM record_anggota";

        if ($_SESSION['username'] !== "timpusat") {
            $query .= " WHERE username='" . $_SESSION['username'] . "' AND id_tps='$id'";
        }
        $data = mysqli_query($koneksi, $query);
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
        $query = "select nama, COUNT(record_anggota.id_record) AS jumlah, id_tps, username from record_anggota
            join wilayah_2020 on wilayah_2020.kode = record_anggota.id_kecamatan";
        if ($_SESSION['username'] !== "timpusat") {
            $query .= " WHERE username='" . $_SESSION['username'] . "' AND id_regency='$id' GROUP BY wilayah_2020.nama;";
        }
        $data = mysqli_query($koneksi, $query);
        $no = 1;
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['nama']; ?></td>
                <td><?php
                    $query2 = "SELECT full_name FROM record_anggota
                       JOIN wilayah_2020 ON wilayah_2020.kode = record_anggota.id_kecamatan
                       WHERE id_tps='" . $d['id_tps'] . "' AND jabatan=3";
                    $filtered = mysqli_query($koneksi, $query2);

                    // Check if there's any data found in the second query
                    if (mysqli_num_rows($filtered) > 0) {
                        $filteredData = mysqli_fetch_array($filtered);
                        echo $filteredData['full_name'];
                    } else {
                        echo "Belum Ada Koordinator TPS";
                    }
                    ?></td>
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
        $query = "select nama, count(id_record) as jumlah, id_tps, username from record_anggota
            join wilayah_2020 on wilayah_2020.kode = record_anggota.id_desa";
        if ($_SESSION['username'] !== "timpusat") {
            $query .= " WHERE username='" . $_SESSION['username'] . "' AND id_kecamatan='$id' GROUP BY wilayah_2020.nama;";
        }
        $data = mysqli_query($koneksi, $query);
        $no = 1;
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['nama']; ?></td>
                <td><?php
                    $query2 = "SELECT full_name FROM record_anggota
                       JOIN wilayah_2020 ON wilayah_2020.kode = record_anggota.id_kecamatan
                       WHERE id_tps='" . $d['id_tps'] . "' AND jabatan=3";
                    $filtered = mysqli_query($koneksi, $query2);

                    // Check if there's any data found in the second query
                    if (mysqli_num_rows($filtered) > 0) {
                        $filteredData = mysqli_fetch_array($filtered);
                        echo $filteredData['full_name'];
                    } else {
                        echo "Belum Ada Koordinator TPS";
                    }
                    ?></td>
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
        $query = "select id_tps, count(id_tps) as jumlah, id_tps, username from record_anggota";
        if ($_SESSION['username'] !== "timpusat") {
            $query .= " WHERE username='" . $_SESSION['username'] . "' AND id_desa='$id' GROUP BY id_tps;";
        }
        $data = mysqli_query($koneksi, $query);
        $no = 1;
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo ("TPS " . substr($d['id_tps'], strrpos($d['id_tps'], '.') + 1)); ?></td>
                <td><?php
                    $query2 = "SELECT full_name FROM record_anggota
                       JOIN wilayah_2020 ON wilayah_2020.kode = record_anggota.id_kecamatan
                       WHERE id_tps='" . $d['id_tps'] . "' AND jabatan=3";
                    $filtered = mysqli_query($koneksi, $query2);

                    // Check if there's any data found in the second query
                    if (mysqli_num_rows($filtered) > 0) {
                        $filteredData = mysqli_fetch_array($filtered);
                        echo $filteredData['full_name'];
                    } else {
                        echo "Belum Ada Koordinator TPS";
                    }
                    ?></td>
                <td><?php echo $d['jumlah']; ?></td>
            </tr>
        <?php }    ?>
    </tbody>
<?php
}

?>