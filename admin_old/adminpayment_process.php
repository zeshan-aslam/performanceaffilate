<?php	ob_start();

//-------------payment process---------------------//

 include '../includes/session.php';
 include '../includes/constants.php';
 include '../includes/functions.php';
 include '../includes/allstripslashes.php';


 $partners=new partners;
 $partners->connection($host,$user,$pass,$db);

	$affiliateid         =	intval($_GET['affiliateid']);
    $merchantid 		 =	intval($_GET['merchantid']);
	$amount    			 =	$_GET['amount'];
	$transid   			 =	intval($_GET['transid']);

	//geting records from table
   	$sql ="select * from partners_bankinfo where bankinfo_affiliateid='$affiliateid'";
	$ret =mysql_query($sql);

	//checking for each records
	if(mysql_num_rows($ret)>0)
	{
	       $row             =mysql_fetch_object($ret);
	       $payment_method  =$row->bankinfo_modeofpay;
	}


   header("location:adminpayment_success.php?amount=$amount&transid=$transid&merchantid=$merchantid&affiliateid=$affiliateid");
   exit;
	?>