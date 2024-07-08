<?php	ob_start();
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	include_once 'language_include.php';
	
	$id				=	$_GET['id'];
	$amount        	=	$_GET['amount'];
	$payment_method	=	$_POST['modofpay'];
	$currValue         =   $_POST['currValue'];
	
	$date	   = date("Y-m-d");
	
	include_once "togateway_upgrade.php";

?>