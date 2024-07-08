<?php	ob_start();

 	include '../includes/session.php';
    include '../includes/constants.php';
 	include '../includes/functions.php';
 	include '../includes/allstripslashes.php';


	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	$affiliateid         =intval($_GET['affiliateid']);
	$amount              =$_GET['amount'];

	//geting records from table
   	$sql ="select * from partners_bankinfo where bankinfo_affiliateid='$affiliateid'";
	$ret =mysql_query($sql);

	//checking for each records
	if(mysql_num_rows($ret)>0)
	{
	       $row             =mysql_fetch_object($ret);
	       $payment_method  =$row->bankinfo_modeofpay;
	}

    include_once 'togateway.php';

	?>