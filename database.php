<?php
include_once("config.php"); 

// Fungsi untuk mendapatkan semua data dari tabel supplier
function getAllSuppliers() {
    $query = "SELECT * FROM supplier";
    $result = sqlsrv_query(DB, $query);

    $suppliers = [];
    if ($result && sqlsrv_has_rows($result)) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $suppliers[] = $row;
        }
    }
    // DB->close();
    return $suppliers;
}

// Fungsi untuk mendapatkan semua data dari tabel barang
function getAllBarang() {
    $query = "SELECT id_barang, nama_barang, stok, harga_jual from barang";
    $result = sqlsrv_query(DB, $query);

    $barang = [];
    if ($result && sqlsrv_has_rows($result)) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $barang[] = $row;
        }
    }
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
function getTransaksiKeluar() {
    
    $query = "SELECT * FROM vw_riwayat_keluar order by Tanggal desc";
    $result = sqlsrv_query(DB, $query);
    $transaksi = [];
    if ($result && sqlsrv_has_rows($result)) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $transaksi[] = $row;
        }
    }
    return $transaksi;
}


function getTransaksiMasuk() {

    $query = "SELECT * FROM vw_riwayat_masuk order by Tanggal desc";
    $result = sqlsrv_query(DB, $query);
    $transaksi = [];
    if ($result && sqlsrv_has_rows($result)) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
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

function insertDataBarang($data) {
    $conn = DB;

    $query = "INSERT INTO barang (nama_barang, harga_jual, stok) VALUES (?, ?, ?)";
    $params = [
        $data['nama_barang'],
        $data['harga_jual'],
        $data['stok']
    ];

    $stmt = sqlsrv_query($conn, $query, $params);

    return $stmt !== false;
}


function insertDataSupplier($data){
    $nama = htmlspecialchars($data["nama"]);
    $tel = htmlspecialchars($data["tel"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $query = "INSERT INTO supplier (nama_supplier, telepon, alamat) VALUES (?, ?, ?)";
    $params = array($nama, $tel, $alamat);
    return sqlsrv_query(DB, $query, $params);
}

function insertDataCust($data){
    $nama = htmlspecialchars($data["nama_customer"]);
    $tel = htmlspecialchars($data["tel"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $query = "INSERT INTO customer (nama_customer, telepon, alamat) VALUES (?, ?, ?)";
    $params = array($nama, $tel, $alamat);
    return sqlsrv_query(DB, $query, $params);
}

function insertTransaksi($data, $jenis = 'keluar') {
    $conn = DB;

    // Tentukan nama tabel dan kolom sesuai jenis
    if ($jenis === 'keluar') {
        $queryTransaksi = "INSERT INTO transaksi_keluar
        (tanggal, id_customer, metode_pembayaran, id_user)
        OUTPUT INSERTED.id_transaksi_keluar VALUES (?, ?, ?, ?)";
        $params = [
            $data['tanggal'],
            $data['idX'],
            $data['metode_pembayaran'],
            $data['id_user']
        ];
        $tabelDetail = 'detail_transaksi_keluar';
        $kolomIdTransaksi = 'id_transaksi_keluar';

    } else { // masuk
        $queryTransaksi = "INSERT INTO transaksi_masuk 
        (tanggal, id_supplier, metode_pembayaran)
        OUTPUT INSERTED.id_transaksi_masuk VALUES (?, ?, ?)";
        $params = [
            $data['tanggal'],
            $data['idX'],
            $data['metode_pembayaran']
        ];
        $tabelDetail = 'detail_transaksi_masuk';
        $kolomIdTransaksi = 'id_transaksi_masuk';
    }

    // Eksekusi insert transaksi utama
    $stmt = sqlsrv_query($conn, $queryTransaksi, $params);
    if (!$stmt) {
        showSqlError();
        return false;
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $id_transaksi = $row[$kolomIdTransaksi];

    // Insert detail transaksi
    $queryDetail = "
        INSERT INTO $tabelDetail ($kolomIdTransaksi, id_barang, jumlah, harga)
        VALUES (?, ?, ?, ?)";

    foreach ($data['items'] as $item) {
        $paramsDetail = [
            $id_transaksi,
            $item['id_barang'],
            $item['jumlah'],
            $item['harga']
        ];

        $stmtDetail = sqlsrv_query($conn, $queryDetail, $paramsDetail);
        if (!$stmtDetail) {
            showSqlError();
            return false;
        }
    }

    // setelah semua detail masuk, jalankan prosedur update harga jual
    if ($jenis !== 'keluar') {
        $stmtUpdate = sqlsrv_query($conn, "EXEC spUpdateHargaJual");
        if (!$stmtUpdate) {
            showSqlError();
            return false;
        }
    }


    return $id_transaksi;
}



function showSqlError() {
    $errors = sqlsrv_errors();
    if ($errors !== null) {
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Code: " . $error['code'] . "<br>";
            echo "Message: " . $error['message'] . "<br>";
        }
    } else {
        echo "SQL Server tidak memberikan error detail.";
    }
}



function getAllCustomers(){
    $query = "SELECT id_customer, nama_customer, alamat, telepon FROM customer";
    $result = sqlsrv_query(DB, $query);
    $pelanggan = [];
    if ($result && sqlsrv_has_rows($result)) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $pelanggan[] = $row;
        }
    }
    // DB->close();
    return $pelanggan;
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


function getAllUser(){
    $query = "SELECT * FROM tampilkan_user";
    $result = sqlsrv_query(DB, $query);
    $user = [];
    if ($result && sqlsrv_has_rows($result)) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $user[] = $row;
        }
    }
    return $user;
}

function insertDataUser($data) {
    $username = htmlspecialchars($data["username"]);
    $pwd_md5 = ($data["pwd"]);
    $level = htmlspecialchars($data["level"]);

    $query = "INSERT INTO [user] (username, pwd, level) VALUES (?, ?, ?)";
    $params = array($username, $pwd_md5, $level);

    return sqlsrv_query(DB, $query, $params);
}

function getDataDetailTransaksiKeluarByID($IDTransaksi){
    $query = sqlsrv_query(DB, "
    select d.id_barang, b.nama_barang Barang, d.harga Harga, d.jumlah Jumlah, d.harga*d.jumlah Subtotal
    from detail_transaksi_keluar d, barang b
    where id_transaksi_keluar=$IDTransaksi and d.id_barang=b.id_barang");
    $result = [];
    if ($query  && sqlsrv_has_rows($query)){
        while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
            $result[] = $row;
        }
    }
    return $result;
}

function getDataDetailTransaksiMasukByID($IDTransaksi){
    $query = sqlsrv_query(DB, "
    select d.id_barang, b.nama_barang Barang, d.harga Harga, d.jumlah Jumlah, d.harga*d.jumlah Subtotal
    from detail_transaksi_masuk d, barang b
    where id_transaksi_masuk=$IDTransaksi and d.id_barang=b.id_barang");
    $result = [];
    if ($query  && sqlsrv_has_rows($query)){
        while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
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

function getDataTransaksiKeluarByID($id){
    $sql = "SELECT 
        transaksi_keluar.id_transaksi_keluar,
        transaksi_keluar.metode_pembayaran,
        total = (SELECT SUM(harga) FROM detail_transaksi_keluar WHERE id_transaksi_keluar = $id),
        transaksi_keluar.tanggal,
        customer.nama_customer
        FROM transaksi_keluar 
        JOIN customer ON transaksi_keluar.id_customer = customer.id_customer
        WHERE transaksi_keluar.id_transaksi_keluar = $id";
    $query = sqlsrv_query(DB, $sql);

    if ($query === false) {
        // Debug: tampilkan error SQLSRV
        die(print_r(sqlsrv_errors(), true));
    }

    return sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
}


function getDataTransaksiMasukByID($id){
    $sql = "SELECT 
        transaksi_masuk.id_transaksi_masuk,
        transaksi_masuk.metode_pembayaran,
        total = (SELECT SUM(harga) FROM detail_transaksi_masuk WHERE id_transaksi_masuk = $id),
        transaksi_masuk.tanggal,
        supplier.nama_supplier
        FROM transaksi_masuk
        JOIN supplier ON transaksi_masuk.id_supplier = supplier.id_supplier
        WHERE transaksi_masuk.id_transaksi_masuk = $id";
    $query = sqlsrv_query(DB, $sql);

    if ($query === false) {
        // Debug: tampilkan error SQLSRV
        die(print_r(sqlsrv_errors(), true));
    }

    return sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
}

function getViewData($viewName) {
    $data = [];
    $stmt = sqlsrv_query(DB, "SELECT * FROM $viewName");
    if ($stmt) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $data[] = $row;
        }
    }
    return $data;
}


function getMarginDataByDateRange($tgl1, $tgl2) {
    $data = [];
    $params = [$tgl1, $tgl2];
    $stmt = sqlsrv_query(DB, "EXEC sp_margin_range_tgl ?, ?", $params);
    if ($stmt) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $data[] = $row;
        }
    }
    return $data;
}
function getBarangById($id) {
    $conn = DB;
    $query = "SELECT * FROM barang WHERE id_barang = ?";
    $stmt = sqlsrv_query($conn, $query, [$id]);

    if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        return $row;
    }

    return false;
}

function updateBarang($id, $nama, $stok, $harga_jual) {
    $conn = DB;
    $query = "UPDATE barang SET nama_barang = ?, stok = ?, harga_jual = ? WHERE id_barang = ?";
    $params = [$nama, $stok, $harga_jual, $id];

    return sqlsrv_query($conn, $query, $params);
}

function getDetailBarangKeluar($id_transaksi, $id_barang) {
    $stmt = sqlsrv_query(DB, "SELECT dtk.jumlah, dtk.harga, b.nama_barang 
                            FROM detail_transaksi_keluar dtk
                            JOIN barang b ON b.id_barang = dtk.id_barang
                            WHERE dtk.id_transaksi_keluar = ? AND dtk.id_barang = ?", 
                            [$id_transaksi, $id_barang]);
    return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
}

function updateDetailBarangKeluar($id_transaksi, $id_barang, $jumlah, $harga) {
    $stmt = sqlsrv_query(DB, "UPDATE detail_transaksi_keluar 
                            SET jumlah = ?, harga = ?
                            WHERE id_transaksi_keluar = ? AND id_barang = ?", 
                            [$jumlah, $harga, $id_transaksi, $id_barang]);
    return $stmt !== false;
}

function deleteDetailBarangKeluar($id_transaksi, $id_barang) {
    $stmt = sqlsrv_query(DB, "DELETE FROM detail_transaksi_keluar 
                            WHERE id_transaksi_keluar = ? AND id_barang = ?", 
                            [$id_transaksi, $id_barang]);
    return $stmt !== false;
}
function getDetailBarangmasuk($id_transaksi, $id_barang) {
    $stmt = sqlsrv_query(DB, "SELECT dtk.jumlah, dtk.harga, b.nama_barang 
                            FROM detail_transaksi_masuk dtk
                            JOIN barang b ON b.id_barang = dtk.id_barang
                            WHERE dtk.id_transaksi_masuk = ? AND dtk.id_barang = ?", 
                            [$id_transaksi, $id_barang]);
    return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
}

function updateDetailBarangmasuk($id_transaksi, $id_barang, $jumlah, $harga) {
    $stmt = sqlsrv_query(DB, "UPDATE detail_transaksi_masuk 
                            SET jumlah = ?, harga = ?
                            WHERE id_transaksi_masuk = ? AND id_barang = ?", 
                            [$jumlah, $harga, $id_transaksi, $id_barang]);
    return $stmt !== false;
}

function deleteDetailBarangmasuk($id_transaksi, $id_barang) {
    $stmt = sqlsrv_query(DB, "DELETE FROM detail_transaksi_masuk 
                            WHERE id_transaksi_masuk = ? AND id_barang = ?", 
                            [$id_transaksi, $id_barang]);
    return $stmt !== false;
}


?>
