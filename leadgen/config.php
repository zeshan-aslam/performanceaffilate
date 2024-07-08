<?php
ob_start();
@session_start();
error_reporting(1);
define('SITEURL','https://avaz.co.uk/leadgen/');
define('LEADURL','https://avaz.co.uk/leadgen/dashboard/');
define('ADMINURL','https://avaz.co.uk/leadgen/admin/');
define('ROOT', __DIR__);
$host = "localhost";
$username = "leadgen";
$password = "bwQw15~1"; 
$databasename = "admin_leadgen";
$prefix = "av_";
$lines  = 10;
$currSymbol  = "&pound;";
include('function.php');
$con = connect($host, $username,  $password, $databasename);
?> 