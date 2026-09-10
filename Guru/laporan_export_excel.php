<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
include '../config/koneksi.php';
include '../app/Models/LaporanModel.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$laporanModel = new LaporanModel($koneksi);

$mapel_id      = $_GET['mapel_id'] ?? null;
$status        = $_GET['status'] ?? null;
$tanggal_awal  = $_GET['tanggal_awal'] ?? null;
$tanggal_akhir = $_GET['tanggal_akhir'] ?? null;

$rekap = $laporanModel->getRekapNilai($mapel_id, $status, $tanggal_awal, $tanggal_akhir);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Rekap Nilai');

$sheet->setCellValue('A1', 'Nama Siswa');
$sheet->setCellValue('B1', 'Mapel');
$sheet->setCellValue('C1', 'Nama Tugas');
$sheet->setCellValue('D1', 'Nilai');
$sheet->setCellValue('E1', 'Status');
$sheet->setCellValue('F1', 'Tanggal Upload');
$sheet->getStyle('A1:F1')->getFont()->setBold(true);

$row = 2;
while ($data = mysqli_fetch_assoc($rekap)) {
    $sheet->setCellValue('A' . $row, $data['nama_siswa']);
    $sheet->setCellValue('B' . $row, $data['nama_mapel']);
    $sheet->setCellValue('C' . $row, $data['nama_tugas']);
    $sheet->setCellValue('D' . $row, $data['nilai']);
    $sheet->setCellValue('E' . $row, $data['status']);
    $sheet->setCellValue('F' . $row, $data['tanggal_upload']);
    $row++;
}

foreach (range('A', 'F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

$filename = 'Rekap_Nilai_' . date('Ymd_His') . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;