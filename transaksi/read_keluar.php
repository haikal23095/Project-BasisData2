<?php
$title = "transaksi";
$page = "transaksi";
include_once "../layout/header.php";

if (isset($_GET['id'])){
  $id = $_GET['id'];
  $detailTransaksiKeluar = getDataDetailTransaksiKeluarByID($id);
  $getDataTransaksiKeluar = getDataTransaksiKeluarByID($id);
  // die(print_r($detailTransaksiKeluar));

} else{
  header('Location: index.php');
  exit;
}

?>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
        <h3>ID Transaksi : <?php echo $getDataTransaksiKeluar['id_transaksi_keluar'] ?> </h3>
        <h3>Nama Pelanggan: <?php echo  $getDataTransaksiKeluar['nama_customer'] ?></h3>
  </div>
  
  <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
  <span> <strong>Metode Pembayaran: </strong><?= $getDataTransaksiKeluar['metode_pembayaran'] ?> </span>
    <span> <strong>Waktu Transaksi:</strong>
    <?= ($getDataTransaksiKeluar['tanggal'] instanceof DateTime) 
        ? $getDataTransaksiKeluar['tanggal']->format('Y-m-d') 
        : $getDataTransaksiKeluar['tanggal'] ?>
  </span>
  </div>
  <p></p>
  <p></p>
  <div class="table-responsive">
    <table class="table table-hover table-bordered">
      <thead class="table-light">
        <tr>
          <th>Barang</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Harga Subtotal</th>
          <th>Aksi</th> <!-- Tambahan -->
        </tr>
      </thead>
      <tbody>
        <?php $total=0; foreach($detailTransaksiKeluar as $row): ?>
          <tr>
            <td><?= $row['Barang'] ?></td>
            <td><?= number_format($row['Harga'],0,',','.') ?></td>
            <td><?= $row['Jumlah'] ?></td>
            <td><?= number_format($row['Subtotal'],0,',','.') ?></td>
            <td>
              <!-- Tombol Aksi -->
              <a href="edit_detail.php?id=<?= $row['id_barang'] ?>&transaksi=<?= $getDataTransaksiKeluar['id_transaksi_keluar'] ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="delete_detail.php?id=<?= $row['id_barang'] ?>&transaksi=<?= $getDataTransaksiKeluar['id_transaksi_keluar'] ?>" 
                class="btn btn-sm btn-danger"
                onclick="return confirm('Yakin ingin menghapus barang ini?');">Hapus</a>
            </td>
            <?php $total += $row['Subtotal'] ?>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <div>
      <strong>Total Harga:</strong> <span id="totalHarga"><?= number_format($total,0,',','.') ?></span>
      <input type="hidden" value="" id="totalHargaPost" name="totalHarga">
  </div>
  <div class="mt-4">
        <a href="index.php" class="btn btn-secondary">&laquo; Kembali</a>
  </div>
</div>

<?php include_once "../layout/footer.php"; ?>