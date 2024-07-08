<?php    	ob_start();

 	include '../includes/session.php';
 	include '../includes/constants.php';
 	include '../includes/functions.php';
 	include '../includes/allstripslashes.php';


 	$partners=new partners;
 	$partners->connection($host,$user,$pass,$db);

    $affiliate_id           =$_GET['affiliateid'];
    $merchant_id	        =$_GET['merchantid'];
	$amount     	    	=$_GET['amount'];
	$transid   			    =$_GET['transid'];
    $today	   			 	=date("Y-m-d");



     //geting records from table
     $merchant_sql ="SELECT * FROM merchant_pay WHERE pay_merchantid='$merchant_id'";
     $merchant_ret =mysql_query($merchant_sql);

     //checking for each records
     if(mysql_num_rows($merchant_ret)>0)
     {
             $row                  =mysql_fetch_object($merchant_ret);
             $merchant_pay_amount  =$row->pay_amount;

     }

    if(($merchant_pay_amount-$amount)>=0){


   	 //updating record if paynebt success
	    $sql ="update partners_transaction set transaction_adminpaydate='$today',transaction_adminpaid='$amount' where transaction_id='$transid' ";
	    $ret =mysql_query($sql);




	     //geting records from table
	     $admin_sql ="SELECT * FROM   admin_pay ";
	     $admin_ret =mysql_query($admin_sql);

	     //checking for each records
	     if(mysql_num_rows($admin_ret)>0)
	     {
	             $row                  =mysql_fetch_object($admin_ret);
	             $admin_pay_amount     =$row->pay_amount;

	     }


	    $merchant_pay_amount    =  $merchant_pay_amount - $amount;
	    $admin_pay_amount       =  $admin_pay_amount +  $amount;


	     //paying for merchant
	    $sql ="update merchant_pay set pay_amount='$merchant_pay_amount' where pay_merchantid='$merchant_id'";
	    $ret =mysql_query($sql);

	     //paying for admin
	    $sql ="update admin_pay set pay_amount='$admin_pay_amount' ";
	    $ret =mysql_query($sql);

	    $msg="Payment Successfull!!!";
	    $msg=urlencode($msg);
    }
    else{
        $msg="Payment Failed.No Money in merchant account!!!";
	    $msg=urlencode($msg);
    }

    header("location:index.php?Act=admin_payments&msg=$msg");
    exit;

?>