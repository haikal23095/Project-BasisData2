<?php
$title = "Tambah user";
$page = "user";

include_once("../layout/header.php");
include_once(BASEPATH . "/functions.php");


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [
        'username'=>'',
        'pwd'=>'',
        'nama'=>'',
        'alamat'=>'',
        'noHP'=>'',
        'level'=>'',
    ];
// username
// pwd
// nama
// alamat
// noHP
// level
    $username = trim($_POST['username']);
    $pwd = trim($_POST['pwd']);
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $noHP = trim($_POST['noHP']);
    $level = isset($_POST['level']) ? trim($_POST['level']) : "";


    validateUname($username, $errors['username']) ;
    validatePwd($pwd, $errors['pwd']) ;
    validateName($nama, $errors['nama']) ;
    validateAlamat($alamat, $errors['alamat']) ;
    validateTel($noHP, $errors['noHP']) ;
    validateSelectInput($level, $errors['level']) ;

    if (empty($errors['username']) && empty($errors['pwd']) && empty($errors['nama']) && empty($errors['alamat']) && empty($errors['noHP']) && empty($errors['level'])){
        if (insertDataUser($_POST)) {
            header("Location: " . BASEURL . "/user/index.php");
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
            <label for="username" class="form-label fw-bold">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']?>"  >
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['username'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['username'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="pwd" class="form-label fw-bold">Password</label>
            <input type="password" class="form-control" id="pwd" name="pwd" value="<?php if (isset($_POST['pwd'])) echo $_POST['pwd']?>" >
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['pwd'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['pwd'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="nama" class="form-label fw-bold">Nama User</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?php if (isset($_POST['nama'])) echo $_POST['nama']?>" >
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['nama'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['nama'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="alamat" class="form-label fw-bold">Alamat</label>
            <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1" rows="3"><?= (isset($_POST['alamat'])) ? $_POST['alamat']:'' ?></textarea>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['alamat'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['alamat'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="noHP" class="form-label fw-bold">Nomor HP</label>
            <input type="tel" class="form-control" id="noHP" name="noHP" value="<?php if (isset($_POST['noHP'])) echo $_POST['noHP'] ?>" >
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['noHP'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['noHP'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="level" class="form-label fw-bold">Jenis User</label>
            <select class="form-select" aria-label="Default select example" name="level">
                <option disabled selected> --- Pilih ---</option>
                <option value="1" <?= (isset($_POST['level']) && $_POST['level'] == '1') ? 'selected' : '' ?> >Owner</option>
                <option value="2" <?= (isset($_POST['level']) && $_POST['level'] == '2') ? 'selected' : '' ?> >Kasir</option>
            </select>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['level'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['level'].'</div><br>' : ''; }?>

        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= BASEURL ?>/user" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include_once("../layout/footer.php") ?>