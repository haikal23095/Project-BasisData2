<?php
$title = "Tambah user";
$page = "user";

include_once("../layout/header.php");
include_once(BASEPATH . "/functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [
        'username'=>'',
        'pwd'=>'',
        'level'=>'',
    ];

    $username = trim($_POST['username']);
    $pwd = trim($_POST['pwd']);
    $level = isset($_POST['level']) ? trim($_POST['level']) : "";

    validateUname($username, $errors['username']);
    validatePwd($pwd, $errors['pwd']);
    validateSelectInput($level, $errors['level']);

    if (empty($errors['username']) && empty($errors['pwd']) && empty($errors['level'])) {
        // Hanya kirim data yang diperlukan ke fungsi insert
        $data = [
            'username' => $username,
            'pwd' => $pwd,
            'level' => $level
        ];
        if (insertDataUser($data)) {
            header("Location: " . BASEURL . "/user/index.php");
            exit;
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
        <?php 
        if ($_SERVER['REQUEST_METHOD']=='POST') { 
            if (!empty($errors['pwd'])) { 
                echo "<div class='alert alert-danger p-2'>{$errors['pwd']}</div><br>"; 
            } 
        } 
        ?>
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
