<?php	ob_start();

#  includes all ssi
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';
    include_once '../includes/session.php';
    include_once '../includes/allstripslashes.php';

	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);


  $pgmid		= intval(trim($_GET['programs']));       //programid
  $prgmType		= trim($_POST['programtype']);
  $prgmFee		= trim($_POST['program']);
  $prgmValue	= intval(trim($_POST['recur_value']))." ".trim($_POST['recur_period']);

  if(!is_numeric($prgmFee)){
   $msg="Enter Valid Amount!!!";
   header("location:index.php?Act=programs&programs=$pgmid&msg=$msg");
   exit();
  }

 $sql = "UPDATE partners_program SET program_fee = '$prgmFee' , program_type ='$prgmType', program_value = '$prgmValue'  WHERE program_id = '$pgmid' ";

 mysql_query($sql)or die($sql."<br/>".mysql_error());
 $msg  = "";
 header("location:index.php?Act=programs&programs=$pgmid&msg=$msg");
 exit;


?>

