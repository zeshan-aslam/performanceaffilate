<?php

	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	include_once 'language_include.php';
	
	$mid	=	$_GET['id'];
	$amount	=	$_GET['amount'];

//----------------------------------  security -------------------------------------------------------------//
	$secid               =$_GET['secid'];
	$secpass             =$_GET['secpass'];

	$secsql	= "select * from random_gen where rand_genid='$secid' and rand_genpwd='$secpass'";
	$secres=mysqli_query($con,$secsql);
	if(mysqli_num_rows($secres)>0)
	{
		$secdel ="delete from random_gen where rand_genid='$secid' and rand_genpwd='$secpass'";
		mysqli_query($con,$secdel);
	}
	else
	{
		$msg1=$lang_perror;
		header("Location:index.php?Act=accounts&msg1=$msg1");
		exit;
	}


// ----------------------------- security test end ------------------------------------------//


    $merchant_sql ="SELECT * FROM   merchant_pay  WHERE pay_merchantid='$mid'";
  	$merchant_ret =mysqli_query($con,$merchant_sql);

	  //checking for each records
	  if(mysqli_num_rows($merchant_ret)>0)
	  {
	          $row                  =mysqli_fetch_object($merchant_ret);
	         $merchant_pay_amount  =$row->pay_amount;


	  }
    $grandtotal	= $merchant_pay_amount+$amount;

    $sql		="UPDATE `merchant_pay` SET `pay_amount` = '$grandtotal' WHERE `pay_merchantid` = '$mid'";
    mysqli_query($con,$sql);

    echo mysqli_error($con);

    $today=date("Y-m-d");
    $sql3  = "INSERT INTO `partners_adjustment` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date` )  ";
    $sql3 .= "VALUES ('', '$mid', 'deposit', 'm','$amount','$today')";
    mysqli_query($con,$sql3);

    $sql        ="UPDATE `partners_merchant` SET merchant_type='advance' where `merchant_id` = '$mid'";
    mysqli_query($con,$sql);

    echo mysqli_error($con);

    $_SESSION['MERCHANTBALANCE']    =   $grandtotal;

	$msg1	="Upgraded Successfully";

    header("Location:index.php?Act=accounts&msg1=$msg1");

?>