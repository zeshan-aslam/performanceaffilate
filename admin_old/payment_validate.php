<?php	

 //*****************************************************************************/
    include_once '../includes/db-connect.php';
    include_once '../includes/session.php';
    include '../includes/constants.php';
    include '../includes/functions.php';
    include '../includes/allstripslashes.php';

    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);

    /*********************variables********************************************/
    $login			=(trim($_POST['login']));         //  login name
    $passwd			=(trim($_POST['passwd']));        //  login passord
    /**************************************************************************/

  	$sql="select * from partners_paymentgateway where pay_id='$payid'";
  	$ret=mysqli_query($con,$sql);
	$row=mysqli_fetch_object($ret);
	if($dome=="Inactive")
    {
    	$sets="In-activated";
    }
	else
    {
     	$sets="Activate";
    }
    $sql="update partners_paymentgateway set pay_status='$dome' where pay_id='$payid'";
	mysqli_query($con,$sql);
    echo mysqli_error($con);
	if($sets=="Activate")
    	$msg=stripslashes($paynam)." Activated.";
	else
    	$msg=stripslashes($paynam)." In-activated.";
	$hed="Location:index.php?Act=payments&payid=$payid&paynam=".stripslashes($paynam)."&msg=$msg";
	header ($hed);
?>