<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
include '../config/koneksi.php';
include '../app/Models/LaporanModel.php';

use Dompdf\Dompdf;

$laporanModel = new LaporanModel($koneksi);

$mapel_id      = $_GET['mapel_id'] ?? null;
$status        = $_GET['status'] ?? null;
$tanggal_awal  = $_GET['tanggal_awal'] ?? null;
$tanggal_akhir = $_GET['tanggal_akhir'] ?? null;

$rekap = $laporanModel->getRekapNilai($mapel_id, $status, $tanggal_awal, $tanggal_akhir);

ob_start();
?>
<html>
<head>
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    h2 { text-align: center; margin-bottom: 0; }
    p.sub { text-align: center; color: #555; margin-top: 4px; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { border: 1px solid #333; padding: 6px; text-align: left; }
    th { background: #f0c419; }
</style>
</head>
<body>
    <h2>Laporan Rekap Nilai</h2>
    <p class="sub">Dicetak pada: <?= date('d M Y H:i') ?></p>

    <table>
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Mapel</th>
                <th>Nama Tugas</th>
                <th>Nilai</th>
                <th>Status</th>
                <th>Tanggal Upload</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($data = mysqli_fetch_assoc($rekap)): ?>
            <tr>
                <td><?= htmlspecialchars($data['nama_siswa']) ?></td>
                <td><?= htmlspecialchars($data['nama_mapel']) ?></td>
                <td><?= htmlspecialchars($data['nama_tugas']) ?></td>
                <td><?= $data['nilai'] ?></td>
                <td><?= htmlspecialchars($data['status']) ?></td>
                <td><?= date('d M Y', strtotime($data['tanggal_upload'])) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
<?php
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('Rekap_Nilai_' . date('Ymd_His') . '.pdf', ['Attachment' => true]);
exit;