<?php
$title = "User";
$page = "user";

include_once("../layout/header.php");
include_once(BASEPATH . "/functions.php");


if (isset($_GET["id"])) {
    $id =  $_GET['id']; 
    $user = getDataUserByID($id);
}else {
    header("location:index.php");
    exit;
}
// print_r($users);
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
    $level = trim($_POST['level']);


    validateUname($username, $errors['username']) ;
    validatePwd($pwd, $errors['pwd']) ;
    validateName($nama, $errors['nama']) ;
    validateAlamat($alamat, $errors['alamat']) ;
    validateTel($noHP, $errors['noHP']) ;
    validateSelectInput($level, $errors['level']) ;

    if (empty($errors['username']) && empty($errors['pwd']) && empty($errors['nama']) && empty($errors['alamat']) && empty($errors['noHP']) && empty($errors['level'])){
        if (updateDataUser($_POST)) {
            header("Location: " . BASEURL . "/user/index.php");
        } else {
            echo "<script>
            alert('data gagal di ubah');
            </script>";
        }
    }
}






?>
<div class="container">
    <!-- <?php var_dump($user)?><br><br>
    <?php isset($_POST) ? var_dump($_POST):''?> -->
    <h2 class="py-4"><?= $title ?></h2>
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?=$user['id']?>">
        <div class="mb-3">
            <label for="username" class="form-label fw-bold">Username</label>
            <input type="text" class="form-control" id="username" name="username" 
            value="<?= (isset($_POST['username'])) ? $_POST['username'] : $user['username']; ?>">
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['username'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['username'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="pwd" class="form-label fw-bold">Password</label>
            <input type="password" class="form-control" id="pwd" name="pwd" 
            value="<?= (isset($_POST['pwd'])) ? $_POST['pwd'] : ''; ?>">
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['pwd'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['pwd'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="nama" class="form-label fw-bold">Nama User</label>
            <input type="text" class="form-control" id="nama" name="nama" 
            value="<?= (isset($_POST['nama'])) ? $_POST['nama'] : $user['nama']; ?>">
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['nama'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['nama'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="alamat" class="form-label fw-bold">Alamat</label>
            <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1" rows="3"><?= (isset($_POST['alamat'])) ? $_POST['alamat'] : $user['alamat']; ?></textarea>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['alamat'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['alamat'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="noHP" class="form-label fw-bold">Nomor HP</label>
            <input type="tel" class="form-control" id="noHP" name="noHP" 
            value="<?= (isset($_POST['noHP'])) ? $_POST['noHP'] : $user['tel']; ?>">
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['noHP'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['noHP'].'</div><br>' : ''; }?>

        <div class="mb-3">
            <label for="level" class="form-label fw-bold">Jenis User</label>
            <select class="form-select" aria-label="Default select example" name="level">
                <option disabled> --- Pilih --- </option>
                <option value="1" <?= $user['level']==1 ? 'selected':''?> >Owner</option>
                <option value="2" <?= $user['level']==2 ? 'selected':''?> >Kasir</option>
            </select>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD']=='POST'){ echo (!empty($errors['level'])) ? '<div class=\'alert alert-danger p-2\'>'.$errors['level'].'</div><br>' : ''; }?>

        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= BASEURL ?>/user" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include_once("../layout/footer.php") ?>