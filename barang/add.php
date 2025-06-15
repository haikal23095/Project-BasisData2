<?php
$title = "Tambah Barang";
$page = "barang";

include_once("../layout/header.php");
include_once(BASEPATH . "/functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [
        'nama_barang' => '',
        'harga_jual' => '',
        'stok' => '',
    ];

    $nama_barang = trim($_POST['nama_barang']);
    $harga_jual = trim($_POST['harga_jual']);
    $stok = trim($_POST['stok']);

    validateBarangName($nama_barang, $errors['nama_barang']);
    validateNumber($harga_jual, $errors['harga_jual']);
    validateInt($stok, $errors['stok']);

    if (empty($errors['nama_barang']) && empty($errors['harga_jual']) && empty($errors['stok'])) {
        $data = [
            'nama_barang' => $nama_barang,
            'harga_jual' => $harga_jual,
            'stok' => $stok,
        ];
        if (insertDataBarang($data)) {
            header("Location: " . BASEURL . "/barang/index.php");
            exit;
        } else {
            echo "<script>alert('Data gagal disimpan');</script>";
        }
    }
}
?>

<div class="container">
    <h2 class="py-4"><?= $title ?></h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="nama_barang" class="form-label fw-bold">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= htmlspecialchars($_POST['nama_barang'] ?? '') ?>">
            <?php if (!empty($errors['nama_barang'])): ?>
                <div class="alert alert-danger p-2 mt-1"><?= $errors['nama_barang'] ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="harga_jual" class="form-label fw-bold">Harga Jual</label>
            <input type="text" class="form-control" id="harga_jual" name="harga_jual" value="<?= htmlspecialchars($_POST['harga_jual'] ?? '') ?>">
            <?php if (!empty($errors['harga_jual'])): ?>
                <div class="alert alert-danger p-2 mt-1"><?= $errors['harga_jual'] ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label fw-bold">Stok</label>
            <input type="text" class="form-control" id="stok" name="stok" value="<?= htmlspecialchars($_POST['stok'] ?? '') ?>">
            <?php if (!empty($errors['stok'])): ?>
                <div class="alert alert-danger p-2 mt-1"><?= $errors['stok'] ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= BASEURL ?>/barang" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include_once("../layout/footer.php"); ?>
