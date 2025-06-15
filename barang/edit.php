<?php
$title = "Edit Barang";
$page = "barang";

include_once("../layout/header.php");
include_once(BASEPATH . "/functions.php");

// Tangkap ID barang dari URL
$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id) {
    echo "<script>alert('ID barang tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}

// Ambil data barang
$barang = getBarangById($id);
if (!$barang) {
    echo "<script>alert('Barang tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_barang'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga_jual'];

    $berhasil = updateBarang($id, $nama, $stok, $harga);

    if ($berhasil) {
        echo "<script>alert('Barang berhasil diperbarui'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui barang');</script>";
    }
}
?>

<div class="container pt-5">
    <h3 class="fw-semibold mb-4">Edit Barang</h3>
    <form method="POST">
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required value="<?= htmlspecialchars($barang['nama_barang']) ?>">
        </div>
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" required value="<?= $barang['stok'] ?>">
        </div>
        <div class="mb-3">
            <label for="harga_jual" class="form-label">Harga Jual</label>
            <input type="number" class="form-control" id="harga_jual" name="harga_jual" required value="<?= $barang['harga_jual'] ?>" step="1000">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include_once "../layout/footer.php"; ?>
