<?php
include "config/connection.php";

$data = $_POST['data'];
$id = $_POST['id'];

$n = strlen($id);
$m = ($n == 2 ? 5 : ($n == 5 ? 10 : 13));
// $wil=($n==2?'Kota/Kab':($n==5?'Kecamatan':'Desa/Kelurahan'));
?>
<?php
if ($data == "kabupaten") {
?>
	<select name="id_kabupaten" id="form_kec">
		<option value="">Pilih Kabupaten</option>
		<?php
		$allowed_codes = ['07', '08', '79', '18'];
		$allowed_codes_string = "'" . implode("','", $allowed_codes) . "'";

		$daerah = mysqli_query($koneksi, "SELECT kode, nama FROM wilayah_2020 WHERE LEFT(kode, '$n') = '$id' AND CHAR_LENGTH(kode) = $m AND kode IN ($allowed_codes_string) ORDER BY nama");

		while ($d = mysqli_fetch_array($daerah)) {
		?>
			<option value="<?php echo $d['kode']; ?>"><?php echo $d['nama']; ?></option>
		<?php
		}
		?>
	</select>
<?php
} else if ($data == "kecamatan") {
?>
	<select name="id_kecamatan" id="form_kec">
		<option value="">Pilih Kecamatan</option>
		<?php
		$daerah = mysqli_query($koneksi, "SELECT kode,nama FROM wilayah_2020 WHERE LEFT(kode,'$n')='$id' AND CHAR_LENGTH(kode)=8 ORDER BY nama");

		while ($d = mysqli_fetch_array($daerah)) {
		?>
			<option value="<?php echo $d['kode']; ?>"><?php echo $d['nama']; ?></option>
		<?php
		}
		?>
	</select>
<?php
} else if ($data == "desa") {
?>

	<select name="id_desa" id="form_kel">
		<option value="">Pilih Desa</option>
		<?php
		$daerah = mysqli_query($koneksi, "SELECT kode,nama FROM wilayah_2020 WHERE LEFT(kode,'$n')='$id' AND CHAR_LENGTH(kode)=$m ORDER BY nama");
		while ($d = mysqli_fetch_array($daerah)) {
		?>
			<option value="<?php echo $d['kode']; ?>"><?php echo $d['nama']; ?></option>
		<?php
		}
		?>
	</select>
<?php

} else if ($data == "tps") {
?>

	<select name="id_tps" id="form_tps">
		<option value="">Pilih TPS</option>
		<?php
		$daerah = mysqli_query($koneksi, "SELECT id_tps, CAST(SUBSTRING(id_tps, 15, 17) AS UNSIGNED) as tps_code FROM tps WHERE id_village='$id' ORDER BY tps_code ASC");
		while ($d = mysqli_fetch_array($daerah)) {
		?>
			<option value="<?php echo $d['id_tps']; ?>">TPS <?php echo $d['tps_code']; ?></option>
		<?php
		}
		?>
	</select>
<?php

} ?>