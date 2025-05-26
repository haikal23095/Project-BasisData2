<?php 
include_once "layout/header.php";
  $totalHargaTransaksi = DB->query("SELECT sum(harga_total) as total_harga FROM transaksi_detail WHERE id_transaksi=45")->fetch_assoc();
  var_dump($totalHargaTransaksi);
  // $query = ""
?>