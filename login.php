<?php 
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/project_modul/config.php");
include_once(BASEPATH . "/database.php");
include_once(BASEPATH . "/functions.php");
if ($_SERVER['REQUEST_METHOD']=="POST"){
  $err = [];
  checkLogin($_POST, $err);
}
if (isset($_SESSION['user'])){
  header('location:index.php');
}
?>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<div class="container">
  <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
    <h2>Hasil Tani Store | Login </h2>
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


