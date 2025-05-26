<?php
include_once("config.php"); 

// Fungsi untuk mendapatkan semua data dari tabel supplier
function getAllSupplier() {
    $query = "SELECT * FROM supplier";
    $result = DB->query($query);

    $suppliers = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = $row;
        }
    }
    // DB->close();
    return $suppliers;
}

// Fungsi untuk mendapatkan semua data dari tabel barang
function getAllBarang() {
    $query = "SELECT
    barang.id,
    barang.kode,
    barang.nama,
    barang.harga,
    barang.stok,
    supplier.nama as nama_supplier
    FROM barang
    JOIN supplier ON barang.id_supplier = supplier.id";
    $result = DB->query($query);

    $barang = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $barang[] = $row;
        }
    }
    // DB->close();
    return $barang;
}

function getBarangNotYetByTransaksiID($transaksiID){
    $sql = DB->query( "SELECT * FROM barang
    where id not in(
    select id_barang from transaksi_detail
    where id_transaksi = $transaksiID
    )");
    $result = [];
    if ($sql->num_rows>0){
        while ($row = $sql->fetch_assoc()) {
            $result[] = $row;
        }
    }
    return $result; 
}
// SELECT id, kode, `nama`, `harga`, `stok`, `id_supplier` FROM `barang` WHERE 1

// Fungsi untuk mendapatkan semua data dari tabel transaksi
function getAllTransaksi() {
    
    $query = "SELECT 
        transaksi.id, 
        transaksi.waktuTransaksi, 
        transaksi.keterangan, 
        transaksi.total, 
        pelanggan.nama AS nama_pelanggan
    FROM transaksi
    JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id
    order by waktuTransaksi";
    $result = DB->query($query);

    $transaksi = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transaksi[] = $row;
        }
    }
    // DB->close();
    return $transaksi;
}

// Fungsi untuk mendapatkan semua data dari tabel transaksi_detail
function getAllTransaksiDetail() {
    $query = "SELECT * FROM transaksi_detail";
    $result = DB->query($query);

    $transaksiDetail = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transaksiDetail[] = $row;
        }
    }
    // DB->close();
    return $transaksiDetail;
}


function insertDataSupplier($data){
    $nama = htmlspecialchars($data["nama"]);
    $tel = htmlspecialchars($data["tel"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $query = "INSERT into supplier
    (nama, tel, alamat) VALUES
    ('$nama', '$tel', '$alamat')
    ";
    return DB->query($query);
}


function getDataSupplierById($id){
    $query = "SELECT * from supplier where id=$id";
    // DB->close();
    return (mysqli_query(DB, $query)->fetch_assoc());
}

// function editDataSupplier($data){

// }

function getAllPelanggan(){
    $query = "SELECT id, nama, gender, tel, alamat FROM pelanggan WHERE 1";
    $result = DB->query($query);
    $pelanggan = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pelanggan[] = $row;
        }
    }
    // DB->close();
    return $pelanggan;
}

function insertTransaksi1_getLastID($IDPelanggan){
    // $today = date("Y-m-d");
    $query = "INSERT into transaksi(id_pelanggan)
    values ($IDPelanggan)";
    $result = DB->query($query);
    return DB->insert_id;
}

function updateDataTransaksi(){
    $query = "UPDATE transaksi
    JOIN (
        SELECT id_transaksi, SUM(harga_total) AS total_harga
        FROM transaksi_detail
        GROUP BY id_transaksi
    ) AS subquery ON transaksi.id = subquery.id_transaksi
    SET transaksi.total = subquery.total_harga
    -- where transaksi.total = 0
    ";
    if (mysqli_query(DB, $query)){
        return true;
    }else {
        return false;
    }
}

function insertDetailTransaksi($data){
    $id_harga_barang = explode('#', $data["id_harga_barang"]);
    $qty = (float)$data["qty"];
    $transaksiID = (int)$data['transaksiID'];
    $id_barang = (int)$id_harga_barang[0];
    $harga_barang  = (float)$id_harga_barang[1];
    $harga_total = $harga_barang*$qty;
    if (DB->query("INSERT INTO transaksi_detail(id_transaksi, id_barang, harga_total, qty) VALUES ($transaksiID,$id_barang,$harga_total,$qty)")){
        if (updateDataTransaksiByID($transaksiID)) return true;
        else return false;
    }
    else {
        return false;
    }
}



function getTransaksiByRange($start, $end){
    $query = "SELECT waktuTransaksi, total FROM transaksi where waktuTransaksi BETWEEN '$start' AND '$end' ORDER BY transaksi.waktuTransaksi ASC";
    $result = DB->query($query);

    $transaksiByRange = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transaksiByRange[] = $row;
        }
    }
    // DB->close();
    return $transaksiByRange;
}

function getTransaksiSummaryByDateRange($start, $end){
    $query = 
    "SELECT waktuTransaksi, SUM(total) AS total_harian, COUNT(DISTINCT id_pelanggan) AS jumlah_pelanggan
    FROM transaksi
    WHERE waktuTransaksi BETWEEN '$start' AND '$end'
    GROUP BY waktuTransaksi
    ORDER BY waktuTransaksi ASC
    ";

    $total_semua_harga = 0;
    $jumlah_pelanggan = 0;
    $transaksi_data = [];
    $result = DB->query($query);
    $index = 1;
    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            $transaksi_data[]=$row;
            $total_semua_harga += $row['total_harian'];
            $jumlah_pelanggan += $row['jumlah_pelanggan'];
            $index++;
        }
    }
    $allData = [
        'transaksiData'=>$transaksi_data,
        'totalSemuaHarga'=>$total_semua_harga,
        'jumlah_pelanggan'=>$jumlah_pelanggan
    ];
    return $allData; 
}

function getAllUser(){
    $query = "SELECT * FROM user";
    $result = mysqli_query(DB, $query);
    $user = [];
    if ($result->num_rows>0){
        while ($row = $result->fetch_assoc()){
            $user[]= $row;
        }
    }
    return $user;
}

function insertDataUser($dataPOST){
    $username = htmlspecialchars($dataPOST["username"]);
    $pwd_md5 = md5(($dataPOST["pwd"]));
    $nama = htmlspecialchars($dataPOST["nama"]);
    $alamat = htmlspecialchars($dataPOST["alamat"]);
    $noHP = htmlspecialchars($dataPOST["noHP"]);
    $level = htmlspecialchars($dataPOST["level"]);

    $query = "INSERT into 
    user (id, username, pwd, nama, alamat, tel, level)
    VALUES (null,'$username','$pwd_md5','$nama','$alamat','$noHP','$level')
    ";
    return DB->query($query);
}

// function runUpdate(){
//     $pilih = DB->query("SELECT id, pwd FROM user");
//     while ($row = $pilih->fetch_assoc()){
//         $id = $row['id'];
//         $pwd = $row['pwd'];
//         $pwd_md5 = md5($pwd);
//         $update = DB->query("UPDATE user set pwd='$pwd_md5' where id=$id");
//     }
// }

function getDataDetailTransaksiByIDTransaksi($IDTransaksi){
    $query = DB->query("SELECT 
	barang.nama,
	barang.harga,
	transaksi_detail.harga_total,
    transaksi_detail.qty
    FROM transaksi_detail
	join barang ON transaksi_detail.id_barang = barang.id
    where transaksi_detail.id_transaksi = $IDTransaksi
    ");
    $result = [];
    if ($query->num_rows>0){
        while ($row = $query->fetch_assoc()) {
            $result[] = $row;
        }
    }
    return $result;
}

function updateDataSupplier($dataPOST){
    $nama = htmlspecialchars($dataPOST["nama"]);
    $tel = htmlspecialchars($dataPOST["tel"]);
    $alamat = htmlspecialchars($dataPOST["alamat"]);
    $id = $dataPOST['id'];
    $query = "UPDATE supplier set nama= '$nama', tel = '$tel', alamat = '$alamat'
    where id=$id";
    return DB->query($query); 
}

function deleteSupplier($id){
    $query = "DELETE from supplier where id=$id";
    return DB->query($query);
}

function getDataTransaksiByID($id){
    $query = DB->query("SELECT 
    transaksi.id,
    transaksi.keterangan,
    transaksi.total,
    transaksi.waktuTransaksi,
    pelanggan.nama as nama_pelanggan
    from transaksi join pelanggan on transaksi.id_pelanggan = pelanggan.id
    where transaksi.id=$id");
    return $query->fetch_assoc();
}
// function getDataDetailTransaksiById($id){
//     $query = DB->query("SELECT
//     transaksi_detail.harga_total,
//     transaksi_detail.qty,
//     barang.nama as nama_barang,
//     barang.harga as harga_barang
//     FROM transaksi_detail JOIN barang ON barang.id = transaksi_detail.id_barang
//     where id_transaksi=$id
//     ");
//     $result = [];
//     if ($query->num_rows>0){
//         while ($row = $query->fetch_assoc()) {
//             $result[] = $row;
//         }
//     }
//     return $result;
// }

function getDataUserByID($id){
    $query = DB->query("SELECT * FROM user where id=$id");
    return $query->fetch_assoc();
}

function updateDataUser($dataPOST) {
    $username = htmlspecialchars($dataPOST["username"]);
    $pwd = md5($dataPOST["pwd"]);
    $nama = htmlspecialchars($dataPOST["nama"]);
    $alamat = htmlspecialchars($dataPOST["alamat"]);
    $noHP = htmlspecialchars($dataPOST["noHP"]);
    $level = htmlspecialchars($dataPOST["level"]);
    $id = $dataPOST['id'];
    
    $query = "UPDATE user SET
    username='$username',
    pwd='$pwd',
    nama='$nama',
    alamat='$alamat',
    tel='$noHP',
    level='$level'
    where id='$id'";
    return DB->query($query); 
}

function deleteDataUserByID($id){
    $query = "DELETE from user where id=$id";
    return DB->query($query);
}


function insertDataBarang($dataPOST){
    $kode = htmlspecialchars($dataPOST["kode"]);
    $nama = htmlspecialchars($dataPOST["nama"]);
    $harga = htmlspecialchars($dataPOST["harga"]);
    $stok = htmlspecialchars($dataPOST["stok"]);
    $id_supplier = htmlspecialchars($dataPOST["id_supplier"]);

    $query = "INSERT into barang (id, kode, nama, harga, stok, id_supplier)
    values (null,'$kode','$nama',$harga,$stok,$id_supplier)
    ";
    return DB->query($query);
}

function deleteDataBarangByID($id){
    $query = "DELETE from barang where id=$id";
    return DB->query($query);
}

function getBarangByID($id){
    $query = DB->query("SELECT * FROM barang where id=$id");
    return $query->fetch_assoc();
}

function updateDataBarang($dataPOST){
    $kode = htmlspecialchars($dataPOST["kode"]);
    $nama = htmlspecialchars($dataPOST["nama"]);
    $harga = htmlspecialchars($dataPOST["harga"]);
    $stok = htmlspecialchars($dataPOST["stok"]);
    $id_supplier = htmlspecialchars($dataPOST["id_supplier"]);
    $id = $dataPOST['id'];

    $query = "UPDATE barang SET
    kode='$kode',
    nama='$nama',
    harga='$harga',
    stok='$stok',
    id_supplier='$id_supplier'
    where id=$id";
    return DB->query($query);
}

function insertDataPelanggan($data){
    $nama = htmlspecialchars($data["nama"]);
    $gender = htmlspecialchars($data["gender"]);
    $tel = htmlspecialchars($data["tel"]);
    $alamat = htmlspecialchars($data["alamat"]);

    $query = "INSERT INTO pelanggan(id, nama, gender, tel, alamat)
    VALUES (null,'$nama','$gender','$tel','$alamat')";
    return DB->query($query);
}

function deleteDataPelangganByID($id){
    $query = "DELETE from pelanggan where id=$id";
    return DB->query($query);
}

function updateDataPelanggan($data){
    $nama = htmlspecialchars($data["nama"]);
    $gender = htmlspecialchars($data["gender"]);
    $tel = htmlspecialchars($data["tel"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $id = $data['id'];
    $query = "UPDATE pelanggan SET nama='$nama', gender='$gender' ,tel='$tel', alamat='$alamat' WHERE id=$id";
    return DB->query($query);
}

function getDataPelangganByID($id){
    $query = DB->query("SELECT * FROM pelanggan where id=$id");
    return $query->fetch_assoc();
}

function insertTransaksi2($data){
    $waktuTransaksi =  $data['waktuTransaksi'];
    $keterangan =  $data['keterangan'];
    $id =  $data['id'];
    $query="UPDATE transaksi
    SET waktuTransaksi='$waktuTransaksi', keterangan='$keterangan'
    where id=$id";
    return DB->query($query);
}

function updateDataTransaksiByID($ID){
    $totalHargaTransaksi = DB->query("SELECT sum(harga_total) as total_harga FROM transaksi_detail WHERE id_transaksi=$ID")->fetch_assoc()['total_harga'];
    $query = "UPDATE transaksi
    SET total=$totalHargaTransaksi where id=$ID";
    if (mysqli_query(DB, $query)){
        return true;
    }else {
        return false;
    }
}

function getJumlahPelangganAndPendapatanByDateRange($start, $end){
    $query = DB->query("SELECT SUM(total) as jumlah_pendapatan, count(distinct id_pelanggan) as jumlah_pelanggan FROM transaksi
    where waktuTransaksi BETWEEN '$start' and '$end'");

    return $query->fetch_assoc();
}

function getTransaksiSumBaseWaktu_ByDateRange($start, $end){
    $query = DB->query("SELECT
    waktuTransaksi,
    sum(total) as total_harian
    FROM transaksi GROUP BY waktuTransaksi
    HAVING waktuTransaksi between '$start' and '$end'
    ");

    if ($query->num_rows>0){
        $result = [];
        while ($row = $query->fetch_assoc()) {
            $result[] = $row;
        }
        return $result;
    }else {
        return false;
    }
}
?>
