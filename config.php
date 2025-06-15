<?php
// DEFINE BASEPATH, BASEURL, DAN DB

// SESUAIKAN DENGAN PATH DIRECTORY
define('BASEURL', "http://localhost/Project-BasisData2");
define('BASEPATH', $_SERVER["DOCUMENT_ROOT"] . "/Project-BasisData2");
//define('BASEPATH', $_SERVER["DOCUMENT_ROOT"] . "/project_modul");

$serverName = "34.142.189.206"; // atau IP / nama instance
$connectionOptions = [
    "Database" => "basisdata2",
    "Uid" => "SA",
    "PWD" => "BasisData2"
];

// Koneksi
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn) {
    // echo "Koneksi berhasil ke SQL Server!";
} else {
    die(print_r(sqlsrv_errors(), true));
}

define('DB', sqlsrv_connect($serverName, $connectionOptions));

?>
