<?php
$title = "user";
$page = "user";
include_once "../layout/header.php";

$userList = getAllUser();
?> 

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
        <h3 class="fw-semibold">Daftar User</h3>
        <div class="d-flex justify-content-end">
            <a href="add.php"><button type="button" class="btn btn-success">Tambah User</button></a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>ID</th>
                    <th>Level</th>
                    <!-- <th>Aksi</th> -->
                </tr>
            </thead>
            <tbody>
                <?php $nomor = 0; foreach ($userList as $row) : $nomor++; ?>
                    <tr>
                        <td><?= $nomor ?></td>
                        <td><?= $row["username"] ?></td>
                        <td><?= $row["id"] ?></td>
                        <td><?php echo ($row["level"]==1)? "Owner" : "Kasir"; ?></td>
                        <!-- <td>
                            <div class="d-flex" style="gap: 5px;">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</a>
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