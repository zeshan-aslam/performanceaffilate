<?php
session_start();
require_once('../custom-emd/init.php');
$MERCHANTID =  $_SESSION['MERCHANTID'];

function cleanData($value)
{
    $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
    $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");

    return str_replace($search, $replace, $value);
}

if (isset($_POST['UpdatedURLs'])) {
    foreach ($_POST['UpdatedURLs'] as $competitors_url) {

        $org_val .= $competitors_url . '|';
        $new_array = rtrim($org_val, '|');
    }

    $upSQL = "UPDATE `partners_merchant` SET `competitor_urls` = '" . cleanData($new_array) . "' WHERE `merchant_id` = '" . $MERCHANTID . "'";
    $db->run_query($upSQL);
    echo "Data Saved Successfully.";
} else {
    $upSQL = "UPDATE `partners_merchant` SET `competitor_urls` = '' WHERE `merchant_id` = '" . $MERCHANTID . "'";
    $db->run_query($upSQL);
    echo "Data Successfully Cleared.";
}
