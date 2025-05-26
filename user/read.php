<?php
$title = "User";
$page = "user";
include_once "../layout/header.php";

$id = $_GET['id'];
if (!isset($id)) {
  header('Location: index.php');
  exit;
}

$user = getDataUserByID($id);
?>

<div class="container">

  <!-- Header -->
  <div class="d-flex justify-content-center align-items-center mb-4 pt-5">
    <h1>Detail <?= $user['username'] ?></h1>
  </div>

  <div class="d-flex justify-content-center">
    <div class="card" style="min-width: 32rem;">
      <div class="card-body text-center">
        <h4 class="card-title"><?= $user['nama'] ?></h4>
        <p class="card-text"><?= ($user['level']==1) ? 'Owner' : 'Kasir' ?></p>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>ID: </strong> <?= $user['id'] ?></li>
        <li class="list-group-item"><strong>No HP: </strong> <?= $user['tel'] ?></li>
        <li class="list-group-item"><strong>Alamat: </strong> <?= $user['alamat'] ?></li>
      </ul>
      <div class="card-body">
        <a href="index.php" class="card-link">&laquo; Kembali</a>
      </div>
    </div>
  </div>

</div>

<?php include_once "../layout/footer.php"; ?>