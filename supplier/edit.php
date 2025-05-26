<?php
$title = "Edit Supplier";
$page = "supplier";

include_once("../layout/header.php");
include_once(BASEPATH . "/functions.php");

if (isset($_GET["id"])) {
    $id =  $_GET['id'];
    $supplier = getDataSupplierById($id);
}else {
    header("location:index.php");
    exit;
}
// print_r($suppliers);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [
        'nama'=>'',
        'tel'=>'',
        'alamat'=>''
    ];

    $nama = trim($_POST['nama']);
    $tel = trim($_POST['tel']);
    $alamat = trim($_POST['alamat']);

    validateName($nama, $errors['nama']) ;
    validateTel($tel, $errors['tel']) ;
    validateAlamat($alamat, $errors['alamat']);

    if (empty($errors['nama']) && empty($errors['tel']) && empty($errors['alamat'])){
        if (updateDataSupplier($_POST)) {
            header("Location: " . BASEURL . "/supplier/index.php");
        } else {
            echo "<script>
            alert('data gagal di ubah');
            </script>";
        }
    }
}





?>
<div class="container">
    <h2 class="py-4"><?= $title ?></h2>
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?=$supplier['id']?>">
        <div class="mb-3">
            <label for="nama" class="form-label fw-bold">Nama supplier</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= (isset($_POST['nama'])) ? $_POST['nama'] : $supplier['nama']; ?>">
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['nama'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['nama'].'</div><br>' : ''; }?>
        
        <div class="mb-3">
            <label for="tel" class="form-label fw-bold">Telepon supplier</label>
            <input type="tel" class="form-control" id="tel" name="tel" value="<?= (isset($_POST['tel'])) ? $_POST['tel'] : $supplier['tel']; ?>">
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['tel'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['tel'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="alamat" class="form-label fw-bold">Alamat</label>
            <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1" rows="3"><?= (isset($_POST['alamat'])) ? $_POST['alamat'] : $supplier['alamat']; ?></textarea>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['alamat'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['alamat'].'</div><br>' : ''; }?>

        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= BASEURL ?>/supplier" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include_once("../layout/footer.php") ?>