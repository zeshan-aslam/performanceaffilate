<?php
# including all needed files
include_once 'includes/db-connect.php';
include_once 'includes/constants.php';
include_once 'includes/functions.php';
include_once 'includes/session.php';
include_once 'includes/encode_decodeFunction.php';

$testcode = "PB17901";
  
$token = MultipleTimeDecode($_GET['ret']);

if ($token == $testcode) {
    // echo "ok";
    $query = "SELECT * FROM partners_program WHERE program_status='active'";
    $runquery = mysqli_query($con, $query);
    if ($runquery) {
        foreach ($runquery as $data) {
            $liveprogram[] = $data;
        }
        echo json_encode($liveprogram);
    }
} else{
   echo 'access denied';
}

