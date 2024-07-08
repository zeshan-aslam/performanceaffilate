<?php

	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	include_once '../includes/allstripslashes.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	$sortingtable   	   =   $_SESSION['SORTINGTABLE'];
	$mer_sortingtable   =   $_SESSION['MER_SORTINGTABLE'];

	if($sortingtable=!"")
	{
		$sql		="Drop table admin_affil_heap";
		mysqli_query($con, $sql);
		$_SESSION['SORTINGTABLE']="";
	}
	if($mer_sortingtable=!"")
	{
		$sql		="Drop table admin_mer_heap";
		mysqli_query($con, $sql);
		$_SESSION['MER_SORTINGTABLE']="";
	}

?>