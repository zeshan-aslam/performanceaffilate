<?php
session_start();
ob_start();

require_once('custom-emd/init.php');

include_once '../includes/constants.php';
include_once '../includes/functions.php';
include_once '../includes/session.php';
include_once '../includes/allstripslashes.php';

$MERCHANTID =  $_SESSION['MERCHANTID'];

$partners = new partners;
$partners->connection($host, $user, $pass, $db);
include_once 'language_include.php';



function cleanData($value)
{
    $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
    $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");

    return str_replace($search, $replace, $value);
}


    $host       = 'localhost';
    $user       = 'afdbuser';
    $pass       = 'tnf-@840L';
    $db         = 'db_per_aff';

    $mysqli = new mysqli($host, $user, $pass, $db);

    // Check connection
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    }


if($_POST['UpdatedBrands'])
{
    $UpdatedBrands =$_POST['UpdatedBrands'];
    $new_array="";
    foreach($UpdatedBrands as $brand)
    {
       
        $org_val .= $brand . '|';
        $new_array = rtrim($org_val, '|');
    }
   
    // echo $new_array;



    $sql1 = "UPDATE `partners_merchant` SET `brands` = '" . $new_array . "' WHERE `merchant_id` = '" . $MERCHANTID . "'";

    mysqli_query($mysqli, $sql1);

    foreach($UpdatedBrands as $brand)
    {
       
    $sql2 = "INSERT `cons_mer_brands` INTO ('cons_mer_id', 'cons_brand_name') VALUES (18,'searlco')  ";
    mysqli_query($mysqli, $sql2);
    }
    $success_msg = "Brands updated Successfully..!";
    echo $success_msg;
}
else
{
    $sql1 = "UPDATE `partners_merchant` SET `brands` = '" . $new_array . "' WHERE `merchant_id` = '" . $MERCHANTID . "'";

    mysqli_query($mysqli, $sql1);

    foreach($UpdatedBrands as $brand)
    {
    $sql2 = "INSERT `cons_mer_brands` INTO ('cons_mer_id', 'cons_brand_name') VALUES ('".$MERCHANTID."','".$brand."')  ";
    mysqli_query($mysqli, $sql2);
    }

    $success_msg = "Brands Not Selected!";
    echo $success_msg;
}
