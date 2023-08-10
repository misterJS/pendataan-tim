<?php
require 'config/connection.php'; // Gantikan dengan jalur ke file koneksi
require 'vendor/autoload.php'; // Gantikan dengan jalur ke direktori PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

// ... Bagian filter query dan pengaturan header tetap sama

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', '#');
$sheet->setCellValue('B1', 'Tim');
$sheet->setCellValue('C1', 'Jabatan');
$sheet->setCellValue('D1', 'Nama Lengkap');
$sheet->setCellValue('E1', 'Nama Lengkap');
$sheet->setCellValue('F1', 'Nomor Ponsel');
$sheet->setCellValue('G1', 'Kabupaten');
$sheet->setCellValue('H1', 'Kecamatan');
$sheet->setCellValue('I1', 'Desa');
$sheet->setCellValue('J1', 'TPS');
// ... tambahkan header kolom lain sesuai kebutuhan

$result = mysqli_query($koneksi, $query);
$row = 2;
$no = 1;
while ($data = mysqli_fetch_array($result)) {

    $regency_query = "SELECT nama FROM wilayah_2020 WHERE kode = '{$data['id_regency']}'";
    $regency_result = mysqli_query($koneksi, $regency_query);
    $regency_row = mysqli_fetch_assoc($regency_result);
    $regency_name = $regency_row['nama'];

    $kecamatan_query = "SELECT nama FROM wilayah_2020 WHERE kode = '{$data['id_kecamatan']}'";
    $kecamatan_result = mysqli_query($koneksi, $kecamatan_query);
    $kecamatan_row = mysqli_fetch_assoc($kecamatan_result);
    $kecamatan_name = $kecamatan_row['nama'];

    $desa_query = "SELECT nama FROM wilayah_2020 WHERE kode = '{$data['id_desa']}'";
    $desa_result = mysqli_query($koneksi, $desa_query);
    $desa_row = mysqli_fetch_assoc($desa_result);
    $desa_name = $desa_row['nama'];

    $id_tps_substring = substr($data['id_tps'], 15, 17);

    $sheet->setCellValue('A' . $row, $no++);
    $sheet->setCellValue('B' . $row, $data['username']);
    $sheet->setCellValue('C' . $row, $data['jabatan']);
    $sheet->setCellValue('D' . $row, $data['full_name']);
    $sheet->setCellValue('E' . $row, $data['no_ktp']);
    $sheet->setCellValue('F' . $row, $data['phone_number']);
    $sheet->setCellValue('G' . $row, $regency_name);
    $sheet->setCellValue('H' . $row, $kecamatan_name);
    $sheet->setCellValue('I' . $row, $desa_name);
    $sheet->setCellValue('J' . $row, $id_tps_substring);
    // ... tambahkan data kolom lain sesuai kebutuhan
    $row++;
}

$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="data_detail.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
