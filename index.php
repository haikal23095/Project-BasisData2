<?php
$title = "Home";
$page = "home";
include_once "layout/header.php";
$transaksiKeluar = getTransaksiKeluar(); 
$transaksiMasuk = getTransaksiMasuk();
$pelangganList = getAllCustomers();

?>


<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
        <h4 class="fw-semibold text-danger">Daftar Transaksi Keluar</h4>
        <div class="d-flex justify-content-end">
            <a class="text-white text-decoration-none" href="<?= BASEURL ?>/transaksi/add.php?jenis=keluar"><button class="btn btn-success ms-2">Tambah</button></a>
            <a class="text-white text-decoration-none" href="<?= BASEURL ?>/report.php"><button class="btn btn-primary ms-2">Laporan Penjualan</button></a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Waktu Transaksi</th>
                    <th>Pembayaran</th>
                    <th>Total Harga</th>
                    <th>Pelanggan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor = 0;?>
                <?php foreach ($transaksiKeluar as $transaksi) : $nomor++; ?>
                    <tr>
                        <td><?= $nomor ?></td>
                        <td><?= $transaksi["Tanggal"] instanceof DateTime ? $transaksi["Tanggal"]->format('Y-m-d') : $transaksi["Tanggal"] ?></td>
                        <td><?= $transaksi["Pembayaran"] ?></td>
                        <td><?= number_format($transaksi["TotalHarga"],0,',','.')  ?></td>
                        <td><?= $transaksi["Customer"] ?></td>
                        <td>
                            <div class="d-flex" style="gap: 5px;">
                                <a href="<?= BASEURL ?>/transaksi/read_keluar.php?id=<?= $transaksi["IDTransaksiKeluar"] ?>" class="btn btn-sm btn-info">Detail</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> <br><br><br><br>
</div>


<?php
include_once "layout/footer.php";
?>