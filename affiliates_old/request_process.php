<?php		ob_start();
	include_once '../includes/session.php';
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/allstripslashes.php';

	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	include_once 'language_include.php';

	$id 		= $_SESSION['AFFILIATEID'];
	$today      = date("Y-m-d");

	$amount     = $_POST['amount'];
	$balance    = $_GET['balance'];

	if(!(is_numeric($amount)))
	{

	    $msg    ="Invalid Amount";
	    Header("Location:index.php?Act=request&msg=$msg&amount=$amount");
	    exit;
	}
	if(($amount)<$minimum_withdraw)
	{

	    $msg    ="You can't withdraw amount less than ".$minimum_withdraw;
	    Header("Location:index.php?Act=request&msg=$msg&amount=$amount");
	    exit;

	}
	if(($balance-$amount)<0)
	{

	    $msg    ="You can't Withdraw this much amount from your Account";
	    Header("Location:index.php?Act=request&msg=$msg&amount=$amount");
	    exit;

	}
	else
	{

	   //geting records from table

	     $sql1 ="INSERT INTO `partners_request` ( `request_id` , `request_affiliateid` , `request_date`, `request_amount`  , `request_status` )
	     VALUES ( '', '$id', '$today','$amount', 'active' )";
	     $ret1 =mysqli_query($con,$sql1);

	    $msg=$request_success;
	    header("location:index.php?Act=request&msg=$msg");
	    exit;
	   }
?>