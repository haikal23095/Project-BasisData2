<?php
// DEFINE BASEPATH, BASEURL, DAN DB

// SESUAIKAN DENGAN PATH DIRECTORY
define('BASEPATH', $_SERVER["DOCUMENT_ROOT"] . "/project_modul");
define('BASEURL', "http://localhost/project_modul");
define('DB', mysqli_connect("localhost", "root", "", "store"));