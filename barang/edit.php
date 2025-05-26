<?php
$title = "Edit Barang";
$page = "barang";

include_once("../layout/header.php");
include_once(BASEPATH . "/functions.php");

// kode
// nama
// harga
// stok
// id_supplier
if (isset($_GET["id"])) {
    $id =  $_GET['id'];
    $barang = getBarangByID($id);
}else {
    header("location:index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [
        'kode'=>'',
        'nama'=>'',
        'harga'=>'',
        'stok'=>'',
        'id_supplier'=>''
    ];

    // var_dump($_POST);
    $kode = trim($_POST['kode']);
    $nama = trim($_POST['nama']);
    $harga = trim($_POST['harga']);
    $stok = trim($_POST['stok']);
    $id_supplier =  (isset($_POST['id_supplier'])) ? $_POST['id_supplier'] : '';

    validateKode($kode, $errors['kode']) ;
    validateBarangName($nama, $errors['nama']) ;
    validateNumber($harga, $errors['harga']) ;
    validateInt($stok, $errors['stok']) ;
    validateSelectInput($id_supplier, $errors['id_supplier']) ;

    if (empty($errors['kode']) && empty($errors['nama']) && empty($errors['harga']) && empty($errors['stok']) && empty($errors['id_supplier']) ){
        if (updateDataBarang($_POST)) {
            header("Location: " . BASEURL . "/barang/index.php");
        } else {
            echo "<script>
            alert('data gagal di ubah');
            </script>";
        }
    }
}

$suppliers = getAllSupplier();
?>

<div class="container">
    <h2 class="py-4"><?= $title ?></h2>
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?=$barang['id']?>">
        <div class="mb-3">
            <label for="nama" class="form-label fw-bold">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= (isset($_POST['nama']))? $_POST['nama']:$barang['nama'] ?>">
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['nama'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['nama'].'</div><br>' : ''; } ?>
        
        <div class="mb-3">
            <label for="kode" class="form-label fw-bold">Kode</label>
            <input type="text" class="form-control" id="kode" name="kode" value="<?= (isset($_POST['kode']))? $_POST['kode']:$barang['kode']  ?>">
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['kode'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['kode'].'</div><br>' : ''; } ?>

        <div class="mb-3">
            <label for="harga" class="form-label fw-bold">Harga</label>
            <input type="text" class="form-control" id="harga" name="harga" value="<?= (isset($_POST['harga']))? $_POST['harga']:$barang['harga'] ?>">
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['harga'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['harga'].'</div><br>' : ''; } ?>

        <div class="mb-3">
            <label for="stok" class="form-label fw-bold">Stok</label>
            <input type="text" class="form-control" id="stok" name="stok" value="<?= (isset($_POST['stok']))? $_POST['stok']:$barang['stok'] ?>">
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['stok'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['stok'].'</div><br>' : ''; } ?>

        <div class="mb-3">
            <label for="id_supplier" class="form-label fw-bold">Supplier</label>
            <select class="form-select" aria-label="Default select example" name="id_supplier">
                <option disabled selected value=""> --- Pilih --- </option>
                <?php foreach ($suppliers as $row): ?>
                    <option value="<?=$row['id']?>" <?php if (isset($_POST['id_supplier']) && $_POST['id_supplier']==$row['id']){echo 'selected';}elseif (!isset($_POST['id_supplier']) && $row['id']==$barang['id_supplier']){echo 'selected';} ?> > <?=$row['nama'] ?> </option>
                <?php endforeach?>
            </select>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['id_supplier'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['id_supplier'].'</div><br>' : ''; }?>

        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= BASEURL ?>/barang" class="btn btn-secondary">Batal</a>
    </form>
</div>




<?php
include_once("../layout/footer.php");
