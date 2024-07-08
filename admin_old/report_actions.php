<?php
  	include_once '../includes/constants.php';
  	include_once '../includes/functions.php';
  	include_once '../includes/session.php';
   	include_once '../includes/allstripslashes.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

    $d=$_GET['d'];
    $m=$_GET['m'];
    $y=$_GET['y'];
    $dateoftrans=$y."/".$m."/".$d;
    $Merchant=$_POST['Mname'];
    $Affiliate=$_POST['Aname'];
    $_SESSION['MERCHANT']=$Merchant;
    $_SESSION['AFFILIATE']=$Affiliate;

    $sql="SELECT sum( transaction_amttobepaid ) click from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='click'";
    $ret=mysql_query($sql);
    $row=mysql_fetch_object($ret);
    $click=$row->click;
	
    $sql="SELECT sum( transaction_amttobepaid ) lead from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='lead'";
    $ret=mysql_query($sql);

    $row=mysql_fetch_object($ret);
    $lead=$row->lead;
    $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale'";
    $ret=mysql_query($sql);
    $row=mysql_fetch_object($ret);
    $sale=$row->sale;
    header("location:index.php?Act=reports&d=$d&m=$m&y=$y&Merchant=$Merchant&Affiliate=$Affiliate&click=$click&lead=$lead&sale=$sale");
?>