<?php
$title = "Customer";
$page = "customer";
include_once "../layout/header.php";

$pelangganList = getAllCustomers();
// var_dump($pelangganList[8]);
?> 

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
        <h3 class="fw-semibold">Daftar <?= $title ?></h3>
        <div class="d-flex justify-content-end">
            <a href="add.php"><button type="button" class="btn btn-success">Tambah Pelanggan</button></a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <!-- <th>Aksi</th> -->
                </tr>
            </thead>
            <tbody>
                <?php $nomor = 0; foreach ($pelangganList as $row) : $nomor++; ?>
                    <tr>
                        <td><?= $nomor ?></td>
                        <td><?= $row["nama_customer"]?></td>
                        <td><?= $row["alamat"]?></td>
                        <td><?= $row["telepon"] ?></td>
                        <!-- <td>
                            <div class="d-flex" style="gap: 5px;">
                                <a href="edit.php?id=<?= $row['id_customer'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $row['id_customer'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus Pelanggan ini?')">Hapus</a>
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