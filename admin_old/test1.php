<?php	
    include_once '../includes/db-connect.php';
  	include_once '../includes/session.php';
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';
    include_once '../includes/allstripslashes.php';

    $partners	= new partners;
    $partners->connection($host,$user,$pass,$db);
	
    $aid	= intval(trim($_GET['aid']));
    $sql	= " select * from partners_affiliate where affiliate_id= '$aid' ";
    $ret	= mysqli_query($con,$sql);
    $row	= mysqli_fetch_object($ret);
    $_SESSION['AFFILIATEID'] 	= $aid;
    $_SESSION['AFFILIATENAME'] 	= stripslashes($row->affiliate_firstname)." ".stripslashes($row->affiliate_lastname );

    $sql	= "select * from affiliate_pay where pay_affiliateid='$aid' ";
    $ret	= mysqli_query($con,$sql);
    $row	= mysqli_fetch_object($ret);
    $_SESSION['AFFILIATEBALANCE']	= $row->pay_amount;
   //  echo "$MERCHANTID";
    header("location:../affiliates/index.php?Act=Home");
    exit;
?>