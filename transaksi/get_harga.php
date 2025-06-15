<?php
include_once('../database.php'); // Pastikan koneksi DB tersedia

if (isset($_GET['id_barang'])) {
    $id = $_GET['id_barang'];
    $sql = "SELECT harga_jual FROM barang WHERE id_barang = ?";
    $stmt = sqlsrv_query(DB, $sql, [$id]);
    
    if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo json_encode(['harga_jual' => $row['harga_jual']]);
    } else {
        echo json_encode(['harga_jual' => 0]);
    }
}
