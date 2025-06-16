<?php 
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/Project-BasisData2/config.php");
include_once(BASEPATH . "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SERVER['REQUEST_METHOD']=="POST"){
  $err = [];
  checkLogin($_POST, $err);
}
if (isset($_SESSION['user'])){
  header('location:index.php');
  exit;
}
?>
<DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Tani Store | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-5">
      <div class="d-flex jusify-content-space-between">
        <img src="./img/utm_baru.png" alt="logo-utm-baru" class="img-fluid mt-3" style="width: 100px; height: 100px;">
        <h1 class="mt-5 text-info text-center ms-5">SELAMAT DATANG DI MANAJEMEN PERGUDANGAN</h1>
      </div>
    </div>
    <div class="container mt-5">
      <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
        <h2 class="text-primary">Silahkan Login Terlebih Dahulu </h2>
          <form method="POST" action="">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control"  name="username" aria-label="Username">
              </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input required type="password" class="form-control" id="exampleInputPassword1" name="pwd" >
            </div>
            <?php if (!empty($err)): ?>
              <div class="alert alert-danger mt-4">
                <?php foreach ($err as $x): echo $x;?>
                <?php endforeach?>
              </div>
            <?php endif?>
            <button type="submit" class="btn btn-primary">Login</button>
          </form>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>

</html>
