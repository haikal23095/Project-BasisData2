<?php
$title = "transaksi";
$page = "transaksi";
include_once "../layout/header.php";

$transaksiKeluar = getTransaksiKeluar(); 
$transaksiMasuk = getTransaksiMasuk();
$pelangganList = getAllPelanggan();
// print_r($pelangganList)
// print_r($pelangganList);
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
        <h3 class="fw-semibold">Daftar Transaksi</h3>
        <div class="d-flex justify-content-end">
            <?php if ($level=='kasir'): ?>
            <form action="add.php" method="GET" class="d-flex">
                <select name="pelanggan" class="form-select me-2" required>
                    <option value="" disabled selected>Pilih Pelanggan</option>
                    <?php foreach ($pelangganList as $pelanggan) {?>
                        <option value="<?=$pelanggan['id_customer'].'#'.$pelanggan['nama_customer']?>"><?php echo $pelanggan['nama_customer']; ?></option>
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
        <h4 class="fw-semibold text-danger">Daftar Transaksi Keluar</h4>
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
                        <td><?= $transaksi["TotalHarga"]  ?></td>
                        <td><?= $transaksi["Customer"] ?></td>
                        <td>
                            <div class="d-flex" style="gap: 5px;">
                                <a href="read_keluar.php?id=<?= $transaksi["IDTransaksiKeluar"] ?>" class="btn btn-sm btn-info">Detail</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> <br><br><br><br>
    

    <!-- Transaksi Masuk -->
    <div class="table-responsive">
        <h4 class="fw-semibold text-primary">Daftar Transaksi Masuk</h4>
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Waktu Transaksi</th>
                    <th>Pembayaran</th>
                    <th>Total Harga</th>
                    <th>Supplier</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor = 0;?>
                <?php foreach ($transaksiMasuk as $transaksi) : $nomor++; ?>
                    <tr>
                        <td><?= $nomor ?></td>
                        <td><?= $transaksi["Tanggal"] instanceof DateTime ? $transaksi["Tanggal"]->format('Y-m-d') : $transaksi["Tanggal"] ?></td>
                        <td><?= $transaksi["Pembayaran"] ?></td>
                        <td><?= $transaksi["TotalHarga"]  ?></td>
                        <td><?= $transaksi["Supplier"] ?></td>
                        <td>
                            <div class="d-flex" style="gap: 5px;">
                                <a href="read_masuk.php?id=<?= $transaksi['IDTransaksiMasuk'] ?>" class="btn btn-sm btn-info">Detail</a>
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