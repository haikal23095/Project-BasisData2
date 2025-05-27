<?php
function checkLogin($data, &$err){
  $username = $data['username'];
  $pwd = $data['pwd'];
  #echo($_SESSION['pwd']);
  $result = mysqli_query(DB, "SELECT * FROM user where username='$username' AND pwd=md5('$pwd')");
  if (mysqli_num_rows($result)>0){
    $user = mysqli_fetch_assoc($result);
    $_SESSION['user'] = $user;

    $_SESSION['level'] = $user['level']==1?'owner':'kasir';
    return header('location: index.php');
  }
  else {
    $err[] = 'Uname or pwd salah';
    return;
  }
}

function validateName($nama, &$error){
  if (empty($nama)) $error = 'Nama tidak boleh kosong';
  elseif (!preg_match("/^[a-zA-Z\'\-\s\.]+$/", $nama)) $error="masukan format alfabet (a-zA-Z'-., dan spasi)";
  else return true;
  return false;
}

function validateTel($tel, &$error){
  if (empty($tel)) $error = 'Masukan tidak boleh kosong';
  elseif (!preg_match("/^[\d]+$/", $tel)) $error = "masukan hanya boleh angka";
  else return true;
  return false;
}

function validateAlamat($alamat, &$error){
  if (empty($alamat)) $error = "masukan tidak boleh kosong";
  elseif ( preg_match("/^[a-zA-Z\s\d\.]+$/", $alamat)===0 || preg_match_all("/[\d]/", $alamat)===0 || preg_match_all("/[a-zA-Z]/", $alamat)===0 ) $error = "masukan harus alfanumerik (minimal harus ada 1 angka dan 1huruf)";
  else return true;
  return false;
}

function validateUname($username, &$error){
  if (empty($username)) $error = "masukan tidak boleh kosong";
  elseif (preg_match("/^[a-zA-Z\d\.\_]+$/", $username)===0) $error = "Masukan hanya boleh terdiri dari (a-zA-Z\d\.\_)";
  elseif (strlen($username)>12) $error = "Panjang karakter tidak boleh lebih dari 12 karakter";
  else return true;
  return false;
}

function validatePwd($pwd, &$error){
  if (empty($pwd)) $error = "masukan tidak boleh kosong";
  elseif (strlen($pwd)<6) $error = "Minimal berisi 8 karakter";
  else return true;
  return false;
}

function validateSelectInput($selectInput, &$error){
  if (empty($selectInput)) $error = "masukan tidak boleh kosong";
  else return true;
  return false;
}

function validateNumber($x, &$error){
  if (empty($x)) $error =  "masukan tidak boleh kosong";
  elseif (is_numeric($x)===false) $error = "Masukkan angka";
  else return true;
  return false;
}

function validateInt($x, &$error){
  if (empty($x)) $error =  "masukan tidak boleh kosong";
  elseif (!filter_var($x, FILTER_VALIDATE_INT)) $error = "Masukkan angka bulat";
  else return true;
  return false;
}

function validateKode($kode, &$error){
  if (empty($kode)) $error = "masukan tidak boleh kosong";
  elseif ( preg_match("/^[A-Z\d]+$/", $kode)===0) $error = "Masukan hanya boleh berupa huruf kapital dan angka (A-Z, 0-9)";
  else return true;
  return false;
}

function validateBarangName($nama, &$error){
  if (empty($nama)) $error = 'Nama tidak boleh kosong';
  elseif (!preg_match("/^[a-zA-Z\'\-\s\.\d]+$/", $nama)) $error="masukan format alfanumerik (0-9a-zA-Z'-., dan spasi)";
  else return true;
  return false;
}

function validateWaktuTransaksi($waktuTransaksi, &$error){
  if ($waktuTransaksi<date('Y-n-d')) $error = 'Waktu transaksi tidak boleh kurang dari hari ini';
  else return true;
  return false;
}

function validateKeteranganTransaksi($string, &$error){
  if (strlen($string)<3 && strlen($string)!=0) $error = 'Panjang minimal 3 karakter';
  else return true;
  return false;
}
?>