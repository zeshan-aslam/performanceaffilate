<?php
session_start();
ob_start();
include_once '../includes/session.php';
$MERCHANTID =  $_SESSION['MERCHANTID'];
$host       = 'localhost';
$user       = 'afdbuser';
$pass       = 'tnf-@840L';
$db         = 'db_per_aff_clone';

$con = mysqli_connect($host, $user, $pass, $db);
$getData = "SELECT * FROM partners_merchant WHERE merchant_id = '" . $MERCHANTID . "'";
$fetchBrands = mysqli_query($con, $getData);
$data = mysqli_fetch_array($fetchBrands);
if ($fetchBrands) {
    if ($data['brands'] == "") {
        echo "empty";
    } else {
        $newArray = explode('|', $data['brands']);

        echo  json_encode($newArray);
    }
}
