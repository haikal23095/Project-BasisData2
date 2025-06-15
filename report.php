<?php
$title = "Report";
$page = "report";
include_once "layout/header.php";

$data = [];
$report_type = $_GET['report_type'] ?? '';
$tgl1 = $_GET['tgl1'] ?? '';
$tgl2 = $_GET['tgl2'] ?? '';

if ($report_type) {
    if ($report_type === 'sp_margin_range_tgl' && $tgl1 && $tgl2) {
        $data = getMarginDataByDateRange($tgl1, $tgl2);
    } elseif (in_array($report_type, ['margin_perbarang_percustomer', 'penjualan_barang_harian'])) {
        $data = getViewData($report_type);
    }
}

$totals = [];
foreach ($data as $row) {
    foreach ($row as $key => $value) {
        if (is_numeric($value)) {
            if (!isset($totals[$key])) $totals[$key] = 0;
            $totals[$key] += $value;
        }
    }
}

?>

<div class="container my-4">
    <h3 class="mb-4">Laporan</h3>
    <form method="GET" class="row g-3">
        <div class="col-md-4">
            <label for="report_type" class="form-label">Pilih Laporan</label>
            <select name="report_type" id="report_type" class="form-select" onchange="toggleDateInputs()">
                <option value="">-- Pilih --</option>
                <option value="margin_perbarang_percustomer" <?= $report_type == 'margin_perbarang_percustomer' ? 'selected' : '' ?>>Margin per Barang per Customer</option>
                <option value="penjualan_barang_harian" <?= $report_type == 'penjualan_barang_harian' ? 'selected' : '' ?>>penjualan barang harian</option>
                <option value="sp_margin_range_tgl" <?= $report_type == 'sp_margin_range_tgl' ? 'selected' : '' ?>>Margin Berdasarkan Tanggal (SP)</option>
            </select>
        </div>

        <div class="col-md-3 date-range" style="display: <?= $report_type === 'sp_margin_range_tgl' ? 'block' : 'none' ?>">
            <label for="tgl1" class="form-label">Tanggal Awal</label>
            <input type="date" name="tgl1" id="tgl1" class="form-control" value="<?= $tgl1 ?>">
        </div>

        <div class="col-md-3 date-range" style="display: <?= $report_type === 'sp_margin_range_tgl' ? 'block' : 'none' ?>">
            <label for="tgl2" class="form-label">Tanggal Akhir</label>
            <input type="date" name="tgl2" id="tgl2" class="form-control" value="<?= $tgl2 ?>">
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
        </div>
    </form>

    <hr class="my-4">
    <?php if ($data): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <?php foreach (array_keys($data[0]) as $col): ?>
                            <th><?= htmlspecialchars($col) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <?php foreach ($row as $cell): ?>
                                <td>
                                    <?= is_object($cell) ? $cell->format('Y-m-d') : (is_numeric($cell) ? number_format(htmlspecialchars($cell), 0, ',', '.') : htmlspecialchars($cell)) ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <?php if (!empty($totals)): ?>
                    <tfoot>
                        <tr>
                            <?php foreach (array_keys($data[0]) as $col): ?>
                                <th>
                                    <?= isset($totals[$col])
                                        ? number_format($totals[$col], 0, ',', '.')
                                        : '' ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </tfoot>
                <?php endif; ?>
            </table>
        </div>

        <!-- <button class="btn btn-success mt-3" onclick="window.print()">Cetak</button> -->
    <?php elseif ($report_type): ?>
        <div class="alert alert-warning mt-3">Tidak ada data ditemukan untuk pilihan ini.</div>
    <?php endif; ?>
</div>

<script>
function toggleDateInputs() {
    const select = document.getElementById('report_type');
    const showDates = select.value === 'sp_margin_range_tgl';
    document.querySelectorAll('.date-range').forEach(el => {
        el.style.display = showDates ? 'block' : 'none';
    });
}
</script>

<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
</script> -->

<?php include_once "layout/footer.php"; ?>


