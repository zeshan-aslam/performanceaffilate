<?php
ob_start();
@session_start();
error_reporting(0);
define('SITEURL','http://localhost/avaz/');
define('ADMINURL','http://localhost/avaz/admin/');
define('ROOT', __DIR__);
$host = "localhost";
$username = "avazland";
$password = "LandinG2019??"; 
$databasename = "landing";
$prefix = "av_";
include('function.php');
$con = connect($host, $username,  $password, $databasename);
?>