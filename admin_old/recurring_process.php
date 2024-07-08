<?php		ob_start();
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	include_once '../includes/function1.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	include_once 'language_include.php';
	
	/*********************variables********************************************/
	$MERCHANTID                =$_REQUEST['hid_Merchant'];     //merchant id
	
	$action			= $_REQUEST['cmb_action'];
	$values			= explode("~",$action);
	/*************************************************************************/

	//Switching Actions
	switch($values[1])
	{
		case "ViewDetails":
			header("Location: index.php?Act=ViewRecurringDetails&id=$values[0]&merchants=$MERCHANTID");
			exit;
			break;
			
		case "ViewTransaction":
			header("Location: index.php?Act=ViewTransactionDetails&id=$values[0]&merchants=$MERCHANTID");
			exit;
			break;
			
		default:
			header("Location: index.php?Act=recurring&merchants=$MERCHANTID");
			exit;
			break;
	}
?>