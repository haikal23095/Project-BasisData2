<?php
$title = "Edit detail keluar";
$page = "edit_dtk";
include_once "../database.php";

$id_barang = $_GET['id'] ?? null;
$id_transaksi = $_GET['transaksi'] ?? null;

if (!$id_barang || !$id_transaksi) {
    header("Location: index.php");
    exit;
}

deleteDetailBarangKeluar($id_transaksi, $id_barang);
header("Location: read_keluar.php?id=$id_transaksi");
exit;
