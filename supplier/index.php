<?php
$title = "Supplier";
$page = "supplier";
include_once "../layout/header.php";

$supplierList = getAllSuppliers();
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
        <h3 class="fw-semibold">Daftar Supplier</h3>
        <a href="add.php"><button type="button" class="btn btn-success">Tambah Supplier</button></a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <!-- <th>Aksi</th> -->
                </tr>
            </thead>
            <tbody>
                <?php $nomor = 0;?>
                <?php foreach ($supplierList as $supplier) : $nomor++; ?>
                    <tr>
                        <td><?= $nomor ?></td>
                        <td><?= $supplier["nama_supplier"] ?></td>
                        <td><?= $supplier["telepon"] ?></td>
                        <td><?= $supplier["alamat"]  ?></td>
                        <!-- <td>
                            <div class="d-flex" style="gap: 5px;">
                                <a href="edit.php?id=<?= $supplier['id_supplier'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $supplier['id_supplier'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">Hapus</a>
                            </div>
                        </td> -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php
include_once "../layout/footer.php"
?>