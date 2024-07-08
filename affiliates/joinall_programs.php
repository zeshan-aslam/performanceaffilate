<?php

include_once '../includes/db-connect.php';
include_once '../includes/session.php';
$aff_id       = $_SESSION['AFFILIATEID'];
$current_date = date('y-m-d');

$sql_pgm = "SELECT * FROM partners_program";
$result = mysqli_query($con, $sql_pgm);
$joinflag = true;
foreach ($result as $key => $value) {

   $findDupSql = "SELECT joinpgm_id FROM partners_joinpgm WHERE joinpgm_programid = '" . $value['program_id'] . "' AND joinpgm_affiliateid = '" . $aff_id . "' ";
   $findRes    =  mysqli_query($con, $findDupSql);
   mysqli_num_rows($findRes);

   if (mysqli_num_rows($findRes) < 1) {
      $sql = "INSERT INTO partners_joinpgm (joinpgm_status,joinpgm_programid,joinpgm_merchantid,joinpgm_affiliateid,joinpgm_date)
      VALUES ('approved','" . $value['program_id'] . "','" . $value['program_merchantid'] . "','$aff_id','$current_date')";
      $res = mysqli_query($con, $sql);
      $joinflag = false;
   }
}

if ($joinflag) {
   $str = 'All Programs are Already Joined';
   echo json_encode($str);
} else {
   $str = 'All Programs are Joined Successfully!';
   echo json_encode($str);
}
