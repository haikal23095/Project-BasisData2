<?php
// DEFINE BASEPATH, BASEURL, DAN DB

// SESUAIKAN DENGAN PATH DIRECTORY
define('BASEURL', "http://34.126.94.46/Project-BasisData2");
define('BASEPATH', $_SERVER["DOCUMENT_ROOT"] . "/Project-BasisData2");
//define('BASEPATH', $_SERVER["DOCUMENT_ROOT"] . "/project_modul");
define('DB', mysqli_connect("localhost", "root", "diobasdat2", "store"));
