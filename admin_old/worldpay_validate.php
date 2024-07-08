<?php		ob_start();

	include_once '../includes/session.php';
	include_once '../includes/functions.php';
	include_once '../includes/constants.php';
	include_once '../includes/allstripslashes.php';

    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);

	$acno  = trim($_POST['txtacno']);

   	# checking whether a record exist in the table

   	$sql	= "select * from partners_worldpay ";
   	$retpay = mysql_query($sql);

    if(empty($acno)){
      	$msg 	= "Please Enter An Account No";
	  	header("Location:index.php?Act=worldpay&msg=$msg");
	  	exit;
    }

   	if(mysql_num_rows($retpay)>0)
   	{
    	$sql = " update partners_worldpay set worldpay_accno='$acno'";
		mysql_query($sql);
   	}
	else
	{
		$sql = "insert into partners_worldpay (worldpay_accno)values('$acno')";
		mysql_query($sql);
	}

    $msg ="Update Successfull";
	header("Location:index.php?Act=payments&payid=10&mode=edit&msg=$msg");
	exit;

?>