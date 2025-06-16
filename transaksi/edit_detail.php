<?php
$title = "Edit detail keluar";
$page = "edit_dtk";
include_once "../layout/header.php";

$id_barang = $_GET['id'] ?? null;
$id_transaksi = $_GET['transaksi'] ?? null;

if (!$id_barang || !$id_transaksi) {
    header("Location: index.php");
    exit;
}

// Ambil data lama
$data = getDetailBarangKeluar($id_transaksi, $id_barang);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jumlah = $_POST['jumlah'];
    $harga  = $_POST['harga'];

    updateDetailBarangKeluar($id_transaksi, $id_barang, $jumlah, $harga);

    header("Location: read_keluar.php?id=$id_transaksi");
    exit;
}
?>

<div class="container mt-4">
    <h4>Edit Detail Barang</h4>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" class="form-control" value="<?= $data['nama_barang'] ?>" disabled>
        </div>
        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="<?= $data['jumlah'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required step="1000">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="read_keluar.php?id=<?= $id_transaksi ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include_once "../layout/footer.php"; ?>
