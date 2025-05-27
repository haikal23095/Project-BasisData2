<?php
$title = "Report";
$page = "report";
include_once "layout/header.php";
?>
<style>
/* Media Print */
@media print {
    nav, button, a.btn, .d-flex {
        display: none !important;
    }

    .container {
        margin: 0;
        padding: 0;
    }

    .table tbody tr:last-of-type {
        border-bottom: 1px black !important;
    }

    br{
        display: none;
    }
}
</style>
<div class="container my-4">
    <!-- <h2>Laporan Penjualan</h2> -->
    
    <?php if ($_SERVER['REQUEST_METHOD']=="POST"):
        $start = $_POST['start'];
        $end = $_POST['end'];
        echo "<span><b>Laporan Penjualan</b> dari $start sampai $end</span><br><br>";
        echo"<a href='report.php'>
        <button type='button' class='btn btn-primary mb-3'>< Kembali</button>
        </a>";
        $getTransaksiSumBaseWaktu_ByDateRange = getTransaksiSumBaseWaktu_ByDateRange($start, $end);
        $n_pelanggan_AND_total_pendapatan = getJumlahPelangganAndPendapatanByDateRange($start, $end);

        // echo "<br>Hasil: <br>";
        // foreach (getTransaksiSumBaseWaktu_ByDateRange($start, $end) as $x){
        //     var_dump($x);echo "<br><br>";
        // };

        // foreach ($getTransaksiSummaryByDateRange as $key => $value) {
        //     echo "<br>";
        //     echo "<br>";
        //     var_dump($key);echo " --- ";var_dump($value);
        // }
        ?>
        <br>

        <button class="btn btn-warning" onclick="window.print();">Cetak PDF</button>
        <a href="excel.php?start=<?=$start?>&end=<?=$end?>" class="btn btn-warning">Excel</a>
        <div class="row mt-5">
            <div class="col-md-6">
                <h5 class="fw-semibold">Grafik Penjualan</h5>
                <?php if ($getTransaksiSumBaseWaktu_ByDateRange): ?>
                    <canvas id="penjualanChart"></canvas>
                <?php else: ?>
                    <p>Belum ada data Penjualan</p>
                <?php endif ?>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-8">
                <!-- <h5>Laporan Penjualan</h5> -->
                <?php if ($getTransaksiSumBaseWaktu_ByDateRange): 
                    
                    ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=0;foreach ($getTransaksiSumBaseWaktu_ByDateRange as $transaksi) :$no++;                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $transaksi['total_harian']; ?></td>
                                    <td><?= $transaksi['waktuTransaksi']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="2">Jumlah Pelanggan</th>
                            <td colspan="3"><?= $n_pelanggan_AND_total_pendapatan['jumlah_pelanggan']; ?> Orang</td>
                        </tr>
                        <tr>
                            <th colspan="2">Jumlah Pendapatan</th>
                            <td colspan="3"><?= $n_pelanggan_AND_total_pendapatan['jumlah_pendapatan']; ?></td>
                        </tr>
                    </table>
                <?php else: ?>
                    <p>Belum ada data</p>
                <?php endif ?>
            </div>
        </div>

    <?php else: ?>
        <h2 class="fw-semibold">Laporan Penjualan</h2>
        <form action="" method="POST">
            <div class="d-flex justify-content-start mb-3">
                <input type="date" name="start" class="me-3">
                <input type="date" name="end" class="me-3">
                <button type="submit" class="btn btn-success">Tampilkan</button>
            </div>
        </form>
    <?php endif?>
</div>


    <?php
    include_once "layout/footer.php";
    ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Data untuk label dan value dari PHP
    const labels = <?= json_encode(array_column($getTransaksiSumBaseWaktu_ByDateRange, 'waktuTransaksi')) ?>;
    const values = <?= json_encode(array_column($getTransaksiSumBaseWaktu_ByDateRange, 'total_harian')) ?>;

    const ctx = document.getElementById('penjualanChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: values,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y', // Mengatur batang horizontal
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        // text: 'Tanggal Transaksi'
                    }
                },
                y: {
                    title: {
                        display: true,
                        // text: 'Total Penjualan (Rp)'
                    }
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>
