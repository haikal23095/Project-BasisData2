<?php
$title = "Edit Pelanggan";
$page = "pelanggan";

include_once("../layout/header.php");
include_once(BASEPATH . "/functions.php");


if (isset($_GET["id"])) {
    $id =  $_GET['id']; 
    $pelanggan = getDataPelangganByID($id);
}else {
    header("location:index.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [
        'nama'=>'',
        'gender'=>'',
        'tel'=>'',
        'alamat'=>''
    ];
// nama
// gender
// tel
// alamat
    $nama = trim($_POST['nama']);
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
    $tel = trim($_POST['tel']);
    $alamat = trim($_POST['alamat']);
    $id = $_POST['id'];
    $data = [
        'nama'=>$nama,
        'gender'=>$gender,
        'tel'=>$tel,
        'alamat'=>$alamat,
        'id'=>$id,
    ];

    validateName($nama, $errors['nama']) ;
    // validateSelectInput($gender, $errors['gender']) ;
    validateTel($tel, $errors['tel']) ;
    validateAlamat($alamat, $errors['alamat']) ;

    var_dump($data);
    if (empty($errors['nama']) && empty($errors['gender']) && empty($errors['tel']) && empty($errors['alamat'])){
        if (updateDataPelanggan($data)) {
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
        <input type="hidden" name="id" value="<?=$pelanggan['id']?>">
        <div class="mb-3">
            <label for="nama" class="form-label fw-bold">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= (isset($_POST['nama'])) ? $_POST['nama'] : $pelanggan['nama']; ?>"  >
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['nama'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['nama'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="tel" class="form-label fw-bold">Nomor HP</label>
            <input type="tel" class="form-control" id="tel" name="tel" value="<?= (isset($_POST['tel'])) ? $_POST['tel'] : $pelanggan['tel']; ?>" >
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['tel'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['tel'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="alamat" class="form-label fw-bold">Alamat</label>
            <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1" rows="3"><?= (isset($_POST['alamat'])) ? $_POST['alamat'] : $pelanggan['alamat']; ?></textarea>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['alamat'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['alamat'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="gender" class="form-label fw-bold">Gender</label>
            <select class="form-select" aria-label="Default select example" name="gender">
                <option disabled selected value="-"> --- Pilih --- </option>
                <option value="L" <?php if (isset($_POST['gender']) && $_POST['gender']=='L'){echo 'selected';}elseif(!isset($_POST['gender']) && $pelanggan['gender']=='L'){echo 'selected';} ?> > Male </option>
                <option value="P" <?php if (isset($_POST['gender']) && $_POST['gender']=='P'){echo 'selected';}elseif(!isset($_POST['gender']) && $pelanggan['gender']=='P'){echo 'selected';} ?> > Female </option>
            </select>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['gender'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['gender'].'</div><br>' : ''; }?>

        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= BASEURL ?>/pelanggan" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include_once("../layout/footer.php") ?>