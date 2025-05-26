<?php
session_start();
# SESUAIKAN SESUAIKAN DENGAN PATH DIRECTORY
// include_once($_SERVER["DOCUMENT_ROOT"] . "/project_modul/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/project_modul/config.php");
include_once(BASEPATH .  "/database.php");
if (!isset($_SESSION['user'])){
  header("location: /project_modul/login.php");
  exit;
}
$level = ($_SESSION['level']);
if ($level==='kasir' && ($page==='supplier'||$page==='barang'||$page==='user'||$page==='pelanggan')){
  header("location: /project_modul/");
}

?>
<!DOCTYPE html>
<html lang="en"> 

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <link rel="stylesheet" href="<?= BASEURL ?>/assets/style.css">
  <title>Hasil Tani Store | <?= $title ?></title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="pembungkus container py-2">
      <a class="navbar-brand fw-bold text-secondary visible" href="<?= BASEURL ?>/index.php">Hasil Tani Store</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link <?= ($page === "home") ? 'text-light fw-bold' : '' ?>" href="<?= BASEURL ?>/index.php">Home</a>
          </li>
          <?php if ($level==='owner'): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php 
              if ($page==='barang') echo "<span class='text-light fw-bold'>Barang</span>";
              elseif ($page==='supplier') echo "<span class='text-light fw-bold'>Supplier</span>";
              elseif($page==='pelanggan') echo "<span class='text-light fw-bold'>Pelanggan</span>";
              elseif($page==='user') echo "<span class='text-light fw-bold'>User</span>";
              else echo "Master";
              ?>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= BASEURL ?>/barang/index.php">Barang</a></li>
              <li><a class="dropdown-item" href="<?= BASEURL ?>/supplier/index.php">Supplier</a></li>
              <li><a class="dropdown-item" href="<?= BASEURL ?>/pelanggan/index.php">Pelanggan</a></li>
              <li><a class="dropdown-item" href="<?= BASEURL ?>/user/index.php">User</a></li>
              <!-- <li><hr class="dropdown-divider"></li> -->
              <!-- <li><a class="dropdown-item" href="#">Something else here</a></li> -->
            </ul>
          </li>
          <?php endif?>
          <li class="nav-item">
            <a class="nav-link <?= ($page === 'transaksi') ? 'text-light fw-bold' : '' ?>" href="<?= BASEURL ?>/transaksi/index.php">Transaksi</a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($page === 'report') ? 'text-light fw-bold' : '' ?>" href="<?= BASEURL ?>/report.php">Report</a>
          </li>
        </ul>

        
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="text-<?= ($page === 'profile') ? 'light fw-bold' : 'secondary'; ?>"><?php echo (isset($_SESSION['user']))? $_SESSION['user']['nama']:''?></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark">
              <!-- <li><a class="dropdown-item" href="#">Profile</a></li> -->
              <li><a class="dropdown-item bg-danger" href="<?= BASEURL ?>/logout.php" onclick="return confirm('apakah anda yakin ingin logout')">Logout</a></li>
            </ul>
          </li>
        </ul>

      </div>
    </div>
  </nav>
