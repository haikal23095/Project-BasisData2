<?php
session_start();
# SESUAIKAN SESUAIKAN DENGAN PATH DIRECTORY
// include_once($_SERVER["DOCUMENT_ROOT"] . "/project_modul/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/Project-BasisData2/config.php");
include_once(BASEPATH .  "/database.php");
if (!isset($_SESSION['user'])){
  header("location: /Project-BasisData2/login.php");
  exit;
}
$level = ($_SESSION['level']);
if ($level==='kasir' && ($page==='supplier'||$page==='barang'||$page==='user'||$page==='customer')){
  header("location: /Project-BasisData2/");
  exit;
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
  <title>MANAJEMEN PERGUDANGAN | <?= $title ?></title>
</head>

<body>
<?php
// Tentukan judul master menu dan apakah aktif
$masterPages = ['barang', 'supplier', 'customer', 'user'];
$isMasterActive = in_array($page, $masterPages);
$masterTitle = $isMasterActive ? ucfirst($page) : 'Master';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container py-2">
    <a class="navbar-brand fw-bold text-light" href="<?= BASEURL ?>/index.php">SISTEM MANAJEMEN PERGUDANGAN</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar">
      <ul class="navbar-nav mx-auto">
        <!-- Home -->
        <li class="nav-item">
          <a class="nav-link <?= ($page === "home") ? 'text-light fw-bold' : '' ?>" href="<?= BASEURL ?>/index.php">Home</a>
        </li>

        <!-- Master (Only for Owner) -->
        <?php if ($level === 'owner'): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?= $isMasterActive ? 'text-light fw-bold' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= $masterTitle ?>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= BASEURL ?>/barang/index.php">Barang</a></li>
              <li><a class="dropdown-item" href="<?= BASEURL ?>/supplier/index.php">Supplier</a></li>
              <li><a class="dropdown-item" href="<?= BASEURL ?>/pelanggan/index.php">Customer</a></li>
              <li><a class="dropdown-item" href="<?= BASEURL ?>/user/index.php">User</a></li>
            </ul>
          </li>
        <?php endif; ?>

        <!-- Transaksi -->
        <li class="nav-item">
          <a class="nav-link <?= ($page === 'masuk') ? 'text-light fw-bold' : '' ?>" href="<?= BASEURL ?>/transaksi/index.php">Masuk</a>
        </li>

        <!-- Report -->
        <li class="nav-item">
          <a class="nav-link <?= ($page === 'report') ? 'text-light fw-bold' : '' ?>"
          href="<?= BASEURL ?>/report.php?report_type=margin_perbarang_percustomer">
          Report</a>
        </li>
      </ul>

      <!-- Profile & Logout -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <button class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="text-light fw-bold"><?= $_SESSION['user']['username'] ?? '' ?></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item bg-info text-light fw-semibold" href="<?= BASEURL ?>/logout.php" onclick="return confirm('apakah anda yakin ingin logout')">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
