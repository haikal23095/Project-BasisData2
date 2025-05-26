<?php
$title = "transaksi";
$page = "transaksi";
include_once "../layout/header.php";

$transaksiList = getAllTransaksi();
$pelangganList = getAllPelanggan();
// print_r($pelangganList);
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
        <h3>Daftar transaksi</h3>
        <div class="d-flex justify-content-end">
            <?php if ($level): ?>
            <form action="add.php" method="GET" class="d-flex">
                <select name="pelanggan" class="form-select me-2" required>
                    <option value="" disabled selected>Pilih Pelanggan</option>
                    <?php foreach ($pelangganList as $pelanggan) {?>
                        <option value="<?=$pelanggan['id'].'#'.$pelanggan['nama']?>"><?php echo $pelanggan['nama']; ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" class="btn btn-success">Tambah</button>
                    <!-- <button type="submit" class="btn btn-succes"></button> -->
            </form>
            <?php endif?>
            <a class="text-white text-decoration-none" href="<?= BASEURL ?>/report.php"><button class="btn btn-primary ms-2">Laporan Penjualan</button></a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Waktu Transaksi</th>
                    <th>Keterangan</th>
                    <th>Total Harga</th>
                    <th>Pelanggan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor = 0;?>
                <?php foreach ($transaksiList as $transaksi) : $nomor++; ?>
                    <tr>
                        <td><?= $nomor ?></td>
                        <td><?= $transaksi["waktuTransaksi"] ?></td>
                        <td><?= $transaksi["keterangan"] ?></td>
                        <td><?= $transaksi["total"]  ?></td>
                        <td><?= $transaksi["nama_pelanggan"] ?></td>
                        <td>
                            <div class="d-flex" style="gap: 5px;">
                                <a href="read.php?id=<?= $transaksi['id'] ?>" class="btn btn-sm btn-info">Detail</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php
include_once "../layout/footer.php"
?>