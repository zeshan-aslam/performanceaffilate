<?php
  /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO CLOSE ADMIN SESSION
  //*************************************************************************************************/

 include_once '../includes/db-connect.php';
 include '../includes/session.php';
 include '../includes/constants.php';
 include '../includes/functions.php';
 include_once '../includes/allstripslashes.php';

 $partners=new partners;
 $partners->connection($host,$user,$pass,$db);
  //Added for admin session update
            	$ip	= $_SERVER['REMOTE_ADDR'];
		if($_SESSION['ADMINUSERID'] == '1')
		{				
	            $sql = "UPDATE `partners_admin` SET `admin_ip` = '$ip',";
	            $sql .= " `admin_lastLogin` =''";
                mysqli_query ($con, $sql);
		} 
		$sql = "UPDATE `partners_adminusers` SET `adminusers_ip` = '$ip',";
		$sql .= " `adminusers_lastLogin` ='' WHERE adminusers_id='".$_SESSION['ADMINUSERID']."' ";

		mysqli_query ($con, $sql);
		echo mysqli_error($con);
		
 //End of admin session update
	session_destroy();
    $Err	="ad1003";
	header("Location:index.php?Err=$Err");
    exit;
?>