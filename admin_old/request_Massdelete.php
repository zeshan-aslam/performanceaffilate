<?php     ob_start();

 include '../includes/session.php';
 include '../includes/constants.php';
 include '../includes/functions.php';
 include '../includes/allstripslashes.php';

 $partners=new partners;
 $partners->connection($host,$user,$pass,$db);
 $elements      = $_POST['elements'];

for($i=0;$i<count($elements);$i++){
   	$id  = $elements[$i];
 	$sql ="delete  from partners_request where request_id='$id'";
 	$ret =mysql_query($sql);
 }
 $msg ="Request deleted successfully";
 header("location:index.php?Act=request&msg=$msg");
 exit;
?>
