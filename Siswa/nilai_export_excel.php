<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../config/koneksi.php';
include __DIR__ . '/../app/Models/PengumpulanModel.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$siswa_id = $_SESSION['id'] ?? null;

if (!$siswa_id) {
    die('Sesi login tidak ditemukan.');
}

$pengumpulanModel = new PengumpulanModel($koneksi);

$mapel_id      = $_GET['mapel_id'] ?? '';
$status        = $_GET['status'] ?? '';
$tanggal_awal  = $_GET['tanggal_awal'] ?? '';
$tanggal_akhir = $_GET['tanggal_akhir'] ?? '';

$riwayat = $pengumpulanModel->getRiwayatBySiswa(
    $siswa_id, $mapel_id, $status, $tanggal_awal, $tanggal_akhir
);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Nilai Saya');

$sheet->setCellValue('A1', 'Mapel');
$sheet->setCellValue('B1', 'Nama Tugas');
$sheet->setCellValue('C1', 'Nilai');
$sheet->setCellValue('D1', 'Status');
$sheet->setCellValue('E1', 'Tanggal Upload');
$sheet->getStyle('A1:E1')->getFont()->setBold(true);

$row = 2;
while ($data = mysqli_fetch_assoc($riwayat)) {
    $sheet->setCellValue('A' . $row, $data['nama_mapel'] ?? '-');
    $sheet->setCellValue('B' . $row, $data['nama_tugas']);
    $sheet->setCellValue('C' . $row, $data['nilai']);
    $sheet->setCellValue('D' . $row, $data['status']);
    $sheet->setCellValue('E' . $row, $data['tanggal_upload'] ?? '-');
    $row++;
}

foreach (range('A', 'E') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

$filename = 'Nilai_Saya_' . date('Ymd_His') . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;