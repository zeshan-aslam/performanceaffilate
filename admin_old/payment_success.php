<?php

 	include '../includes/session.php';
 	include '../includes/constants.php';
 	include '../includes/functions.php';
 	include '../includes/allstripslashes.php';

 	$partners=new partners;
 	$partners->connection($host,$user,$pass,$db);

	$affiliate_id        =intval($_GET['affiliateid']);
    $merchant_id	     =intval($_GET['merchantid']);
	$amount   			 =$_GET['amount'];
	$transid  			 =intval($_GET['transid']);
    $today	   			 =date("Y-m-d");

    //updating record if paynebt success
    $sql ="update partners_transaction set transaction_amountpaid='$amount',transaction_dateofpayment='$today' where transaction_id='$transid' ";
    $ret =mysql_query($sql);

     //geting records from table
      $merchant_sql ="SELECT * FROM merchant_pay  WHERE pay_merchantid='$merchant_id'";
      $merchant_ret =mysql_query($merchant_sql);

      //checking for each records
      if(mysql_num_rows($merchant_ret)>0)
      	{
              $row                  =mysql_fetch_object($merchant_ret);
              $merchant_pay_amount  =$row->pay_amount;

      	}


      //geting records from table
      $affiliate_sql ="SELECT * FROM   affiliate_pay  WHERE pay_affiliateid='$affiliate_id'";
      $affiliate_ret =mysql_query($affiliate_sql);

      //checking for each records
      if(mysql_num_rows($affiliate_ret)>0)
      	{
              $row                  =mysql_fetch_object($affiliate_ret);
              $affiliate_pay_amount =$row->pay_amount;

      	}

      $merchant_pay_amount  =  $merchant_pay_amount - $amount;
      $affiliate_pay_amount =  $affiliate_pay_amount + $amount;

      //paying for merchant
       $sql ="update merchant_pay set pay_amount='$merchant_pay_amount' where pay_merchantid='$merchant_id'";
       $ret =mysql_query($sql);

      //paying for affiliate
       $sql ="update affiliate_pay set pay_amount='$affiliate_pay_amount' where pay_affiliateid='$affiliate_id'";
       $ret =mysql_query($sql);


    $msg="Payment Successfull!!!";
    $msg=urlencode($msg);
    header("location:index.php?Act=dopayments&msg=$msg");
    exit;

?>