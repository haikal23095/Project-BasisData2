<?php
$title = "Barang";
$page = "barang";
include_once "../layout/header.php";

$barangLists = getAllBarang();
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
        <h3 class="fw-semibold">Daftar Barang</h3>
        <a href="<?= BASEURL ?>/barang/add.php" class="btn btn-success">Tambah barang</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Harga Jual</th>
                    <th>Aksi</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barangLists as $row) : ?>
                    <tr>
                        <td><?= $row["id_barang"] ?></td>
                        <td><?= $row["nama_barang"] ?></td>
                        <td><?= $row["stok"]  ?></td>
                        <td><?= number_format($row["harga_jual"], 0, ',', '.') ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id_barang'] ?>" class="btn btn-sm btn-warning">Edit</a>
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