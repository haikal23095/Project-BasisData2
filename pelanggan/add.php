<?php
$title = "Tambah Pelanggan";
$page = "pelanggan";

include_once("../layout/header.php");
include_once(BASEPATH . "/functions.php");


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
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '-';
    $tel = trim($_POST['tel']);
    $alamat = trim($_POST['alamat']);
    // $id = $_POST['id'];
    $data = [
        'nama'=>$nama,
        'gender'=>$gender,
        'tel'=>$tel,
        'alamat'=>$alamat
        // 'id'=>$id,
    ];

    validateName($nama, $errors['nama']) ;
    // validateSelectInput($gender, $errors['gender']) ;
    validateTel($tel, $errors['tel']) ;
    validateAlamat($alamat, $errors['alamat']) ;

    if (empty($errors['nama']) && empty($errors['gender']) && empty($errors['tel']) && empty($errors['alamat'])){
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
            <label for="nama" class="form-label fw-bold">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?php if (isset($_POST['nama'])) echo $_POST['nama']?>"  >
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['nama'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['nama'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="tel" class="form-label fw-bold">Nomor HP</label>
            <input type="tel" class="form-control" id="tel" name="tel" value="<?php if (isset($_POST['tel'])) echo $_POST['tel'] ?>" >
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['tel'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['tel'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="alamat" class="form-label fw-bold">Alamat</label>
            <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1" rows="3"><?= (isset($_POST['alamat'])) ? $_POST['alamat']:'' ?></textarea>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['alamat'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['alamat'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="gender" class="form-label fw-bold">Gender</label>
            <select class="form-select" aria-label="Default select example" name="gender">
                <option disabled selected> --- Pilih ---</option>
                <option value="L" <?= (isset($_POST['gender']) && $_POST['gender'] == 'L') ? 'selected' : '' ?> >Male</option>
                <option value="P" <?= (isset($_POST['gender']) && $_POST['gender'] == 'P') ? 'selected' : '' ?> >Female</option>
            </select>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['gender'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['gender'].'</div><br>' : ''; }?>

        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= BASEURL ?>/pelanggan" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include_once("../layout/footer.php") ?>