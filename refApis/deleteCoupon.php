<?php
include_once '../includes/constants.php';
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
include_once '../includes/encode_decodeFunction.php';

$d = new DateTime('-1day');
$t_Date = $d->format('d/m/Y');
// Set the API endpoint URL and record ID
// $api_url = "https://performanceaffiliate.com/affiliates/couponApi.php?_token=ecnrtp45jade&CONSAFF=VmtjeGQxVnNRbEpRVkRBOQ==";

$url = "https://performanceaffiliate.com/affiliates/couponApi.php?_token=ecnrtp45jade&CONSAFF=VmtjeGQxVnNRbEpRVkRBOQ==" . $t_Date;

// Set the HTTP context options
$options = array(
  'http' => array(
    'method' => 'DELETE',
    'header' => 'Content-type: application/x-www-form-urlencoded',
  ),
);

// Create a new HTTP context
$context = stream_context_create($options);

// Send the DELETE request to the API endpoint
$result = file_get_contents($url, false, $context);

// Check for errors
if ($result === false) {
  echo "Error: " . error_get_last()['message'];
} else {
  echo "Record deleted successfully.";
}
?>