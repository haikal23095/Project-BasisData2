<?php
$title = "Barang";
$page = "barang";
include_once "../layout/header.php";

$barangLists = getAllBarang();
// print_r($barangLists);
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
        <h3>Daftar barang</h3>
        <a href="<?= BASEURL ?>/barang/add.php" class="btn btn-success">Tambah barang</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Nama Supplier</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor = 0;?>
                <?php foreach ($barangLists as $row) :?>
                    <tr>
                        <td><?= $row["id"] ?></td>
                        <td><?= $row["kode"] ?></td>
                        <td><?= $row["nama"]  ?></td>
                        <td><?= $row["harga"] ?></td>
                        <td><?= $row["stok"] ?></td>
                        <td><?= $row["nama_supplier"] ?></td>
                        <td>
                            <div class="d-flex" style="gap: 5px;">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">Hapus</a>
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