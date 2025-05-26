<?php
include_once 'database.php'; 

$start = $_GET['start'];
$end = $_GET['end'];

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");
header("Cache-Control: max-age=0");

$getTransaksiSumBaseWaktu_ByDateRange = getTransaksiSumBaseWaktu_ByDateRange($start, $end);
$n_pelanggan_AND_total_pendapatan = getJumlahPelangganAndPendapatanByDateRange($start, $end);

$jumlah_pendapatan = $n_pelanggan_AND_total_pendapatan['jumlah_pendapatan'];
$jumlah_pelanggan = $n_pelanggan_AND_total_pendapatan['jumlah_pelanggan'];
?>

<table border="1">
    <thead>
        <tr>
            <th colspan="2">Laporan Penjualan dari rentang <?= $start ?> sampai <?= $end ?></th>
        </tr>
        <tr>
            <th>Total Harian</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($getTransaksiSumBaseWaktu_ByDateRange as $transaksi): ?>
            <tr>
                <td><?= $transaksi['total_harian']; ?></td>
                <td><?= $transaksi['waktuTransaksi']; ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="2">Rekap</th>
        </tr>
        <tr>
            <td>Jumlah Pelanggan</td>
            <td><?= $jumlah_pelanggan; ?> Orang</td>
        </tr>
        <tr>
            <td>Total Pendapatan</td>
            <td><?= $jumlah_pendapatan; ?></td>
        </tr>
    </tbody>
</table>
