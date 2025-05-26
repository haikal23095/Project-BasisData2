<?php
include_once('../layout/header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (deleteDataUserByID($id)) {
        echo "<script>
            alert('data berhasil dihapus');
            window.location = '" . BASEURL . "/user/index.php';
        </script>";
    } else {
        echo "<script>
            alert('gagal dihapus');
            window.location = '" . BASEURL . "/user/index.php';
        </script>";
    }
}