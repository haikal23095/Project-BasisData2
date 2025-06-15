<?php
$title = "Tambah customer";
$page = "Pelanggan";

include_once("../layout/header.php");
include_once(BASEPATH . "/functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [
        'nama_customer'=>'',
        'telepon'=>'',
        'alamat'=>''
    ];

    $nama_customer = trim($_POST['nama_customer']);
    $telepon = trim($_POST['telepon']);
    $alamat = trim($_POST['alamat']);

    $data = [
        'nama_customer'=>$nama_customer,
        'telepon'=>$telepon,
        'alamat'=>$alamat
    ];

    validateName($nama_customer, $errors['nama_customer']);
    validateTel($telepon, $errors['telepon']);
    validateAlamat($alamat, $errors['alamat']);

    if (empty($errors['nama_customer']) && empty($errors['telepon']) && empty($errors['alamat'])){
        if (insertDataPelanggan($data)) {
            header("Location: " . BASEURL . "/pelanggan/index.php");
        } else {
            echo "<script>
            alert('data gagal di tambahkan');
            </script>";
        }
    }
}
?>
<div class="container">
    <h2 class="py-4"><?= $title ?></h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="nama_customer" class="form-label fw-bold">Nama Customer</label>
            <input type="text" class="form-control" id="nama_customer" name="nama_customer" value="<?php if (isset($_POST['nama_customer'])) echo $_POST['nama_customer']?>"  >
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['nama_customer'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['nama_customer'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="telepon" class="form-label fw-bold">Telepon</label>
            <input type="tel" class="form-control" id="telepon" name="telepon" value="<?php if (isset($_POST['telepon'])) echo $_POST['telepon'] ?>" >
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['telepon'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['telepon'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="alamat" class="form-label fw-bold">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" rows="3"><?= (isset($_POST['alamat'])) ? $_POST['alamat']:'' ?></textarea>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['alamat'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['alamat'].'</div><br>' : ''; }?>

        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= BASEURL ?>/pelanggan" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include_once("../layout/footer.php") ?>
