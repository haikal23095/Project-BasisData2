<?php
$title = "transaksi";
$page = "transaksi";
include_once "../layout/header.php";

if (isset($_GET['id'])){
  $id = $_GET['id'];
  $detailTransaksi = getDataDetailTransaksiByIDTransaksi($id);
  $getDataTransaksi = getDataTransaksiByID($id);
  
} else{
  header('Location: index.php');
  exit;
}

?>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
        <h3>ID Transaksi : <?php echo $getDataTransaksi['id'] ?> </h3>
        <h3>Nama Pelanggan: <?php echo  $getDataTransaksi['nama_pelanggan'] ?></h3>
  </div>
  
  <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
  <span> <strong>Keterangan: </strong><?= $getDataTransaksi['keterangan'] ?> </span>
    <span> <strong>Waktu Transaksi:</strong>  <?= $getDataTransaksi['waktuTransaksi'] ?></span>
  </div>
  <p></p>
  <p></p>
  <div class="table-responsive">
    <table class="table table-hover table-bordered">
      <thead class="table-light">
          <tr>
              <th>Barang</th>
              <th>Harga</th>
              <th>Qty</th>
              <th>Harga Total</th>
          </tr>
          <?php foreach($detailTransaksi as $row):?>
            <tr>
              <td><?= $row['nama'] ?></td>
              <td><?= $row['harga'] ?></td>
              <td><?= $row['qty'] ?></td>
              <td><?= $row['harga_total'] ?></td>
            </tr>
          <?php endforeach?>
      </thead>
    </table>
  </div>
  <div>
      <strong>Total Harga:</strong> <span id="totalHarga"><?= $getDataTransaksi['total'] ?></span>
      <input type="hidden" value="" id="totalHargaPost" name="totalHarga">
</div>





  <!-- Header -->
  <!-- <div class="d-flex justify-content-center align-items-center mb-4 pt-5">
    <h1>ID Transaksi: <?= $variable ?></h1>
  </div>

  <div class="d-flex justify-content-center">
    <div class="card" style="min-width: 32rem;">
      <div class="card-body text-center">
        <h4 class="card-title"><?= $detailTransaksi['nama_detailTransaksi'] ?></h4>
        <p class="card-text"><?= $detailTransaksi['deskripsi'] ?></p>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">Jumlah SKS: <?= $detailTransaksi['sks'] ?></li>
        <li class="list-group-item">Tahun Ajaran: <?= $detailTransaksi['tahun_ajaran'] ?></li>
        <li class="list-group-item">Jenis detailTransaksi: <span class="badge text-bg-success"><?= $detailTransaksi['jenis'] ?></span></li>
        <li class="list-group-item">detailTransaksi Prasyarat: <?= $detailTransaksi['prasyarat_id'] ?? "-" ?></li>
      </ul>
      <div class="card-body">
        <a href="index.php" class="card-link">&laquo; Kembali</a>
      </div>
    </div>
  </div> -->

</div>

<?php include_once "../layout/footer.php"; ?>