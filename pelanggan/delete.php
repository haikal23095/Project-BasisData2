<?php
include_once('../layout/header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (deleteDataPelangganByID($id)) {
        echo "<script>
            alert('data berhasil dihapus');
            window.location = '" . BASEURL . "/pelanggan/index.php';
        </script>";
    } else {
        echo "<script>
            alert('gagal dihapus');
            window.location = '" . BASEURL . "/pelanggan/index.php';
        </script>";
    }
}