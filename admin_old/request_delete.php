<?php	ob_start();
 include '../includes/session.php';
 include '../includes/constants.php';
 include '../includes/functions.php';
 include '../includes/allstripslashes.php';

 $partners=new partners;
 $partners->connection($host,$user,$pass,$db);

 $id		=intval($_GET['id']);

 //geting records from table
 $sql ="delete  from partners_request where request_id='$id'";
 $ret =mysql_query($sql);
 $msg ="Request deleted successfully";
 header("location:index.php?Act=request&msg=$msg");
 exit;
?>
