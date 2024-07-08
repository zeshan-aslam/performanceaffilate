<?php

session_start();
ob_start();
include_once '../includes/session.php';
include_once '../includes/db-connect.php';
$MERCHANTID =  $_SESSION['MERCHANTID'];

$getData = "SELECT * FROM partners_merchant WHERE merchant_id = '" . $MERCHANTID . "'";
$fetchURLs = mysqli_query($con, $getData);
$data = mysqli_fetch_array($fetchURLs);
if ($fetchURLs) {
    if ($data['competitor_urls'] == "") {
        echo "empty";
    } else {
        $newURL_Array = explode('|', $data['competitor_urls']);
        // Remove "https://www." from each string in $newURL_Array
        $newURL_Array = array_map(function ($url) {
            // return str_replace('https://www.', '', $url);
            return str_replace(['https://www.', 'www.'], '', $url);

        }, $newURL_Array);

        echo json_encode($newURL_Array);

        // echo  json_encode($newURL_Array);
    }
}
